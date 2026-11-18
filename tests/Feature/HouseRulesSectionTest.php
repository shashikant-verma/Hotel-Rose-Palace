<?php

namespace Tests\Feature;

use App\Models\RoomType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HouseRulesSectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test configuration contains all 9 required categories in exact order with accurate statements.
     */
    public function test_hotel_rules_config_structure_and_categories(): void
    {
        $config = config('hotel_rules');

        $this->assertIsArray($config);
        $this->assertEquals('House Rules & Information', $config['heading']);
        $this->assertArrayHasKey('categories', $config);
        $this->assertCount(9, $config['categories']);

        $expectedCategories = [
            'must-read-rules' => 'MUST READ RULES',
            'guest-profile' => 'GUEST PROFILE',
            'id-proof-related' => 'ID PROOF RELATED',
            'smoking-alcohol-consumption-rules' => 'SMOKING/ALCOHOL CONSUMPTION RULES',
            'food-arrangement' => 'FOOD ARRANGEMENT',
            'property-accessibility' => 'PROPERTY ACCESSIBILITY',
            'pets-related' => 'PET(S) RELATED',
            'other-rules' => 'OTHER RULES',
            'child-extra-bed-policy' => 'CHILD & EXTRA BED POLICY',
        ];

        $actualCategoryIds = array_column($config['categories'], 'id');
        $this->assertEquals(array_keys($expectedCategories), $actualCategoryIds);

        foreach ($config['categories'] as $cat) {
            $this->assertEquals($expectedCategories[$cat['id']], $cat['tab_title']);
            $this->assertNotEmpty($cat['heading']);
            $this->assertNotEmpty($cat['rules']);
        }
    }

    /**
     * Test all exact required policy statements exist in config.
     */
    public function test_hotel_rules_config_contains_all_exact_policy_statements(): void
    {
        $categories = collect(config('hotel_rules.categories'))->keyBy('id');

        // 1. MUST READ RULES
        $mustRead = $categories->get('must-read-rules')['rules'];
        $this->assertContains('Primary Guest should be at least 18 years of age.', $mustRead);
        $this->assertContains('Guests below 18 years of age must be accompanied by a parent or legally authorised guardian at check-in. The hotel may request appropriate identification to verify the accompanying adult\'s identity and authority.', $mustRead);
        $this->assertContains('Stag groups and larger groups consisting exclusively of male guests may not be accommodated at the property. Individual business travellers and two corporate guests may be accepted subject to hotel verification and applicable property rules. The hotel reserves the right to verify guest details at check-in.', $mustRead);
        $this->assertNotContains('Groups with only male guests are not allowed at this property.', $mustRead);
        $this->assertContains('Passport, Aadhaar, Driving License and Govt. ID are accepted as ID proof(s).', $mustRead);
        $this->assertContains('Pets are not allowed.', $mustRead);
        $this->assertContains('Smoking within the premises is not allowed.', $mustRead);

        // 2. GUEST PROFILE
        $guestProfile = $categories->get('guest-profile')['rules'];
        $this->assertContains('Unmarried couples are not allowed.', $guestProfile);
        $this->assertContains('Primary guest should be at least 18 years of age.', $guestProfile);
        $this->assertContains('Guests below 18 years of age must be accompanied by a parent or legally authorised guardian at check-in. The hotel may request appropriate identification to verify the accompanying adult\'s identity and authority.', $guestProfile);
        $this->assertContains('Stag groups and larger groups consisting exclusively of male guests may not be accommodated at the property. Individual business travellers and two corporate guests may be accepted subject to hotel verification and applicable property rules. The hotel reserves the right to verify guest details at check-in.', $guestProfile);
        $this->assertNotContains('Groups with only male guests are not allowed at this property.', $guestProfile);

        // 3. ID PROOF RELATED
        $idProof = $categories->get('id-proof-related')['rules'];
        $this->assertContains('Passport, Aadhaar, Driving License and Govt. ID are accepted as ID proof(s).', $idProof);
        $this->assertContains('Local IDs are not allowed.', $idProof);

        // 4. SMOKING/ALCOHOL CONSUMPTION RULES
        $smokingAlcohol = $categories->get('smoking-alcohol-consumption-rules')['rules'];
        $this->assertContains('There are no restrictions on alcohol consumption.', $smokingAlcohol);
        $this->assertContains('Smoking within the premises is not allowed.', $smokingAlcohol);

        // 5. FOOD ARRANGEMENT
        $food = $categories->get('food-arrangement')['rules'];
        $this->assertContains('Non-veg food is allowed.', $food);
        $this->assertContains('Outside food is allowed.', $food);
        $this->assertContains('Food delivery is available.', $food);
        $this->assertContains('Food delivery available from Zomato, Swiggy and local restaurants.', $food);
        $this->assertContains('In-room dining available.', $food);

        // 6. PROPERTY ACCESSIBILITY
        $accessibility = $categories->get('property-accessibility')['rules'];
        $this->assertContains('This property is not accessible to guests who use a wheelchair. Please make arrangements accordingly.', $accessibility);

        // 7. PET(S) RELATED
        $pets = $categories->get('pets-related')['rules'];
        $this->assertContains('Pets are not allowed.', $pets);
        $this->assertContains('There are no pets living on the property.', $pets);

        // 8. OTHER RULES
        $other = $categories->get('other-rules')['rules'];
        $this->assertContains('Does not allow private parties or events.', $other);
        $this->assertContains('Guests are requested not to invite outside visitors in the room during their stay.', $other);

        // 9. CHILD & EXTRA BED POLICY
        $childBed = $categories->get('child-extra-bed-policy')['rules'];
        $this->assertContains('No extra bed will be provided to accommodate any child included in the booking.', $childBed);
        $this->assertContains('No extra bed will be provided to accommodate any additional guest included in the booking.', $childBed);
    }

    /**
     * Test dedicated /house-rules page renders successfully with all elements.
     */
    public function test_dedicated_house_rules_page_renders_all_tabs_and_rules(): void
    {
        $response = $this->get(route('house-rules'));

        $response->assertStatus(200);
        $response->assertSee('House Rules & Information');
        $response->assertSee('role="tablist"', false);

        // Assert all 9 tab titles are rendered
        $response->assertSee('MUST READ RULES');
        $response->assertSee('GUEST PROFILE');
        $response->assertSee('ID PROOF RELATED');
        $response->assertSee('SMOKING/ALCOHOL CONSUMPTION RULES');
        $response->assertSee('FOOD ARRANGEMENT');
        $response->assertSee('PROPERTY ACCESSIBILITY');
        $response->assertSee('PET(S) RELATED');
        $response->assertSee('OTHER RULES');
        $response->assertSee('CHILD & EXTRA BED POLICY');

        // Assert DOM IDs for scroll-spy / navigation
        $response->assertSee('id="must-read-rules"', false);
        $response->assertSee('id="guest-profile"', false);
        $response->assertSee('id="id-proof-related"', false);
        $response->assertSee('id="smoking-alcohol-consumption-rules"', false);
        $response->assertSee('id="food-arrangement"', false);
        $response->assertSee('id="property-accessibility"', false);
        $response->assertSee('id="pets-related"', false);
        $response->assertSee('id="other-rules"', false);
        $response->assertSee('id="child-extra-bed-policy"', false);

        // Assert key policies are rendered
        $response->assertSee('Primary Guest should be at least 18 years of age.');
        $response->assertSee('Guests below 18 years of age must be accompanied by a parent or legally authorised guardian at check-in.');
        $response->assertSee('Stag groups and larger groups consisting exclusively of male guests may not be accommodated at the property.');
        $response->assertDontSee('Groups with only male guests are not allowed at this property.');
        $response->assertSee('Unmarried couples are not allowed.');
        $response->assertSee('Local IDs are not allowed.');
        $response->assertSee('There are no restrictions on alcohol consumption.');
        $response->assertSee('Non-veg food is allowed.');
        $response->assertSee('This property is not accessible to guests who use a wheelchair.');
        $response->assertSee('No extra bed will be provided to accommodate any child included in the booking.');

        // Assert strictly excluded policies are NOT rendered
        $response->assertDontSee('Credit Card at check-in');
        $response->assertDontSee('Rental Agreement');
        $response->assertDontSee('COVID');
        $response->assertDontSee('Airport Shuttle');
    }

    /**
     * Test room details page includes the house rules section.
     */
    public function test_room_details_page_includes_house_rules_section(): void
    {
        $roomType = RoomType::factory()->create([
            'name' => 'Royal Heritage Suite',
            'slug' => 'royal-heritage-suite',
            'base_price' => 4500,
            'max_occupancy' => 2,
            'is_active' => true,
        ]);

        $response = $this->get(route('room-detail', ['slug' => $roomType->slug]));

        $response->assertStatus(200);
        $response->assertSee('House Rules & Information');
        $response->assertSee('MUST READ RULES');
        $response->assertSee('id="must-read-rules"', false);
        $response->assertSee('Unmarried couples are not allowed.');
        $response->assertSee('CHILD & EXTRA BED POLICY');
    }

    /**
     * Test footer contains link to house rules page.
     */
    public function test_footer_contains_link_to_house_rules(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee(route('house-rules'));
        $response->assertSee('House Rules & Info');
    }
}
