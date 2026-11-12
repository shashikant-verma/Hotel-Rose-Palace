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
        'message',
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
}
