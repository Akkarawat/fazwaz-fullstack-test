<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'for_sale',
        'for_rent',
        'sold',
        'price',
        'currency',
        'currency_symbol',
        'property_type',
        'bedrooms_count',
        'bathrooms_count',
        'area',
        'area_type',
        'country',
        'province',
        'street',
        'photos_thumb',
        'photos_search',
        'photos_full',
    ];

    protected $casts = [
        'for_sale' => 'boolean',
        'for_rent' => 'boolean',
        'sold' => 'boolean',
        'price' => 'decimal:2',
        'bedrooms_count' => 'integer',
        'bathrooms_count' => 'integer',
        'area' => 'decimal:2',
    ];
}
