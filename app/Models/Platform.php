<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'name',
        'email',
        'status',
        'connected_on',
        'credentials',
    ];

    protected $casts = [
        'credentials' => 'array',
        'connected_on' => 'datetime',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
