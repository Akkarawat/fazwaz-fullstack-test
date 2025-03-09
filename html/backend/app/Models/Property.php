<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Property extends Model
{
    use HasFactory;

    protected $casts = [
        'for_sale' => 'boolean',
        'for_rent' => 'boolean',
        'sold' => 'boolean',
        'price' => 'decimal:2',
        'bedrooms_count' => 'integer',
        'bathrooms_count' => 'integer',
        'area' => 'decimal:2',
    ];

    protected $hidden = [
        'photos_thumb',
        'photos_search',
        'photos_full',
        'country',
        'province',
        'street',
    ];


    protected $appends = [
        'geo',
        'photos',
    ];

    protected function geo(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => [
                'country' => $attributes['country'],
                'province' => $attributes['province'],
                'street' => $attributes['street'],
            ]
        );
    }

    protected function photos(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => [
                'thumb' => $attributes['photos_thumb'],
                'search' => $attributes['photos_search'],
                'full' => $attributes['photos_full'],
            ]
        );
    }
}
