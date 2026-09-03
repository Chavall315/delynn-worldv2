<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'photo_url',
        'photo_path',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }
}