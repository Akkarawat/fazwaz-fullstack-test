<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use Illuminate\Support\Facades\File;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $json = File::get(database_path('seeders/data/properties.json'));
        $properties = json_decode($json, true);

        foreach ($properties as $property) {
            Property::create([
                'id' => $property['id'],
                'title' => $property['title'],
                'description' => $property['description'],
                'for_sale' => $property['for_sale'],
                'for_rent' => $property['for_rent'],
                'sold' => $property['sold'],
                'price' => $property['price'],
                'currency' => $property['currency'],
                'currency_symbol' => $property['currency_symbol'],
                'property_type' => $property['property_type'],
                'bedrooms_count' => $property['bedrooms'],
                'bathrooms_count' => $property['bathrooms'],
                'area' => $property['area'],
                'area_type' => $property['area_type'],
                'country' => $property['geo']['country'],
                'province' => $property['geo']['province'],
                'street' => $property['geo']['street'],
                'photos_thumb' => $property['photos']['thumb'],
                'photos_search' => $property['photos']['search'],
                'photos_full' => $property['photos']['full'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
