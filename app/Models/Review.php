<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'business_id',
        'review_id',
        'reviewer_name',
        'comment',
        'star_rating',
        'create_time',
        'update_time',
        'raw_data',
    ];

    protected $casts = [
        'create_time' => 'datetime',
        'update_time' => 'datetime',
        'raw_data'    => 'array', // auto-decodes JSON
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Each review belongs to a business
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors / Helpers
    |--------------------------------------------------------------------------
    */

    // Accessor to display formatted date easily
    public function getFormattedDateAttribute(): ?string
    {
        return $this->create_time ? Carbon::parse($this->create_time)->format('Y-m-d') : null;
    }

    // Accessor to display stars (optional)
    public function getStarsAttribute(): string
    {
        return str_repeat('⭐', (int) $this->star_rating);
    }
}
