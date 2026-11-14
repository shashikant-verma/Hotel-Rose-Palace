<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'is_read',
        'is_replied',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'is_replied' => 'boolean',
        ];
    }

    /**
     * Mark inquiry as read
     */
    public function markAsRead(): bool
    {
        return $this->update([
            'status' => 'read',
            'is_read' => true,
        ]);
    }

    /**
     * Mark inquiry as replied
     */
    public function markAsReplied(): bool
    {
        return $this->update([
            'status' => 'replied',
            'is_read' => true,
            'is_replied' => true,
        ]);
    }

    /**
     * Mark inquiry as new / unread
     */
    public function markAsNew(): bool
    {
        return $this->update([
            'status' => 'new',
            'is_read' => false,
            'is_replied' => false,
        ]);
    }

    /**
     * Scope query by status
     */
    public function scopeWithStatus($query, ?string $status)
    {
        if (empty($status) || $status === 'all') {
            return $query;
        }

        return $query->where('status', $status);
    }
}
