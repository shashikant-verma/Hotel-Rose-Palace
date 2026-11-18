<?php

namespace App\Services;

use App\Models\RoomType;
use App\Models\SeasonalPricing;
use App\Models\PromotionalOffer;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PricingService
{
    /**
     * Tax rate (12% GST)
     */
    protected const TAX_RATE = 0.12;

    /**
     * Calculate the total price for a booking including all applicable rates and taxes
     * 
     * Pricing Priority:
     * 1. Seasonal pricing (if applicable) takes priority over base price
     * 2. Promotional discounts may apply to the selected rate
     * 3. If no seasonal pricing exists, use base price
     * 4. GST is always applied to the final rate before any discount
     * 5. Promotional discount is applied after GST
     */
    public function calculateBookingPrice(
        RoomType $roomType,
        Carbon $checkInDate,
        Carbon $checkOutDate,
        int $quantity = 1,
        bool $includePromotion = true
    ): array {
        // Calculate number of nights
        $nights = $this->calculateNights($checkInDate, $checkOutDate);

        // Collect pricing data for each night
        $nightlyPrices = [];
        $currentDate = $checkInDate->clone();

        while ($currentDate->lt($checkOutDate)) {
            $priceData = $this->getPriceForDate(
                $roomType,
                $currentDate,
                $includePromotion
            );
            $nightlyPrices[] = $priceData;
            $currentDate->addDay();
        }

        // Calculate totals
        $baseSubtotal = 0;
        $discountTotal = 0;
        $details = [];

        foreach ($nightlyPrices as $night) {
            $baseSubtotal += $night['nightly_rate'];
            $discountTotal += $night['discount_amount'] ?? 0;
            $details[] = $night;
        }

        // Calculate for total quantity if multiple rooms
        $baseSubtotal *= $quantity;
        $discountTotal *= $quantity;

        // Apply GST on the base subtotal (after discounts in our priority)
        $tax = round($baseSubtotal * self::TAX_RATE, 2);
        $grandTotal = $baseSubtotal - $discountTotal + $tax;

        return [
            'nights' => $nights,
            'quantity' => $quantity,
            'base_subtotal' => round($baseSubtotal, 2),
            'discount_total' => round($discountTotal, 2),
            'tax_rate' => self::TAX_RATE * 100,
            'tax_amount' => $tax,
            'grand_total' => round($grandTotal, 2),
            'nightly_details' => $details, // For detailed display
            'pricing_source' => $this->determinePricingSource($roomType, $checkInDate, $checkOutDate),
        ];
    }

    /**
     * Get the applicable price for a specific date
     * Returns the rate after applying priority rules (seasonal > base)
     * and applicable promotions
     */
    public function getPriceForDate(
        RoomType $roomType,
        Carbon $date,
        bool $includePromotion = true
    ): array {
        // Start with base price
        $nightly_rate = $roomType->base_price;
        $pricing_type = 'base';

        // Check for seasonal pricing (takes priority)
        $seasonalPrice = SeasonalPricing::where('room_type_id', $roomType->id)
            ->validForDate($date)
            ->orderBy('start_date', 'desc')
            ->first();

        if ($seasonalPrice) {
            $nightly_rate = $seasonalPrice->price;
            $pricing_type = 'seasonal';
            $season_name = $seasonalPrice->season_name;
        }

        $discount_amount = 0;
        $promotion = null;

        // Check for applicable promotional offer
        if ($includePromotion) {
            $promotion = PromotionalOffer::where('room_type_id', $roomType->id)
                ->validForDateTime($date->startOfDay())
                ->first();

            if ($promotion) {
                $discount_amount = $promotion->calculateDiscountAmount($nightly_rate);
                // Ensure discount doesn't make price negative
                if ($nightly_rate - $discount_amount < 0) {
                    $discount_amount = $nightly_rate;
                }
            }
        }

        return [
            'date' => $date->format('Y-m-d'),
            'nightly_rate' => (float) $nightly_rate,
            'pricing_type' => $pricing_type,
            'season_name' => $seasonalPrice->season_name ?? null,
            'discount_amount' => round($discount_amount, 2),
            'discount_type' => $promotion?->discount_type,
            'discount_value' => $promotion?->discount_value,
            'promotion_name' => $promotion?->name,
            'final_rate' => round($nightly_rate - $discount_amount, 2),
        ];
    }

    /**
     * Calculate number of nights between two dates
     * Checkout date is exclusive
     */
    public function calculateNights(Carbon $checkIn, Carbon $checkOut): int
    {
        return $checkIn->diffInDays($checkOut);
    }

    /**
     * Get all applicable seasonal pricing for a room type and date range
     */
    public function getSeasonalPricingForDateRange(
        RoomType $roomType,
        Carbon $startDate,
        Carbon $endDate
    ): Collection {
        return SeasonalPricing::where('room_type_id', $roomType->id)
            ->forRoomTypeAndDateRange($roomType->id, $startDate, $endDate)
            ->orderBy('start_date')
            ->get();
    }

    /**
     * Get all applicable promotional offers for a room type and date range
     */
    public function getPromotionalOffersForDateRange(
        RoomType $roomType,
        Carbon $startDate,
        Carbon $endDate
    ): Collection {
        return PromotionalOffer::where('room_type_id', $roomType->id)
            ->forRoomTypeAndDateRange($roomType->id, $startDate, $endDate)
            ->orderBy('start_date')
            ->get();
    }

    /**
     * Determine the pricing source for a booking period
     */
    protected function determinePricingSource(
        RoomType $roomType,
        Carbon $checkIn,
        Carbon $checkOut
    ): string {
        $hasPromotion = PromotionalOffer::where('room_type_id', $roomType->id)
            ->forRoomTypeAndDateRange($roomType->id, $checkIn, $checkOut)
            ->exists();

        $hasSeasonal = SeasonalPricing::where('room_type_id', $roomType->id)
            ->forRoomTypeAndDateRange($roomType->id, $checkIn, $checkOut)
            ->exists();

        if ($hasSeasonal && $hasPromotion) {
            return 'seasonal_with_promotion';
        } elseif ($hasSeasonal) {
            return 'seasonal';
        } elseif ($hasPromotion) {
            return 'base_with_promotion';
        } else {
            return 'base';
        }
    }

    /**
     * Validate that a new seasonal pricing doesn't conflict with existing ones
     * Returns array with 'valid' => bool and 'conflicts' => array of conflicting pricing
     */
    public function validateSeasonalPricingNoConflict(
        RoomType $roomType,
        Carbon $startDate,
        Carbon $endDate,
        ?int $excludeId = null
    ): array {
        $query = SeasonalPricing::where('room_type_id', $roomType->id)
            ->where('is_active', true)
            ->where(function ($q) use ($startDate, $endDate) {
                $q->where(function ($subQuery) use ($startDate, $endDate) {
                    $subQuery->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $startDate);
                });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $conflicts = $query->get();

        return [
            'valid' => $conflicts->isEmpty(),
            'conflicts' => $conflicts,
        ];
    }

    /**
     * Calculate potential discount preview for display purposes
     * (For showing users what they might save with a promotion)
     */
    public function getDiscountPreview(
        RoomType $roomType,
        Carbon $checkInDate,
        Carbon $checkOutDate
    ): ?array {
        $nights = $this->calculateNights($checkInDate, $checkOutDate);
        $basePrice = $roomType->base_price * $nights;

        // Get the best applicable promotion
        $currentDate = $checkInDate->clone();
        $bestDiscount = 0;
        $bestPromotion = null;

        while ($currentDate->lt($checkOutDate)) {
            $promotion = PromotionalOffer::where('room_type_id', $roomType->id)
                ->validForDateTime($currentDate)
                ->first();

            if ($promotion) {
                $discountAmount = $promotion->calculateDiscountAmount($roomType->base_price);
                if ($discountAmount > $bestDiscount) {
                    $bestDiscount = $discountAmount;
                    $bestPromotion = $promotion;
                }
            }

            $currentDate->addDay();
        }

        if ($bestPromotion) {
            return [
                'promotion_name' => $bestPromotion->name,
                'discount_label' => $bestPromotion->getDiscountLabel(),
                'total_discount' => round($bestDiscount * $nights, 2),
            ];
        }

        return null;
    }
}
