<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Property;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->paragraph(3),
            'for_sale' => $this->faker->boolean(),
            'for_rent' => $this->faker->boolean(),
            'sold' => $this->faker->boolean(false),
            'price' => $this->faker->randomNumber(6),
            'currency' => 'THB',
            'currency_symbol' => '฿',
            'property_type' => $this->faker->randomElement(['Condo', 'House', 'Apartment']),
            'bedrooms_count' => $this->faker->numberBetween(1, 5),
            'bathrooms_count' => $this->faker->numberBetween(1, 5),
            'area' => $this->faker->randomFloat(2, 20, 500),
            'area_type' => 'sqm',
            'country' => 'Thailand',
            'province' => $this->faker->randomElement(['Bangkok', 'Chiang Mai', 'Phuket']),
            'street' => $this->faker->streetAddress(),
            'photos_thumb' => $this->faker->imageUrl(150, 100),
            'photos_search' => $this->faker->imageUrl(300, 150),
            'photos_full' => $this->faker->imageUrl(600, 300),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function soldable(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'for_sale' => true,
                'sold' => false,
            ];
        });
    }
}
