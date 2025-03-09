<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $json = File::get(database_path('seeders/data/properties.json'));
        $properties = json_decode($json, true);

        $startDate = Carbon::parse('2000-01-01 00:00:00');
        $endDate = Carbon::parse('2025-03-01 23:59:59');

        foreach ($properties as $property) {
            $randomeTime = $this->generateRandomDateTime($startDate, $endDate);

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
                'created_at' => $randomeTime,
                'updated_at' => $randomeTime,
            ]);
        }
    }

    private function generateRandomDateTime(Carbon $startDate, Carbon $endDate)
    {
        $startTimestamp = $startDate->timestamp;
        $endTimestamp = $endDate->timestamp;

        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);

        return Carbon::createFromTimestamp($randomTimestamp);
    }
}
