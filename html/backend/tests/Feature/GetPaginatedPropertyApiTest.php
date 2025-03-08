<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Property;

class GetPaginatedPropertyApiTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchesPropertiesSuccessfully()
    {
        Property::factory()->count(5)->soldable()->create();

        $response = $this->getJson('/api/properties');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
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
                        'created_at',
                        'updated_at'
                    ]
                ],
                'total',
                'current_page',
                'per_page'
            ]);
    }

    public function testAppliesPaginationCorrectly()
    {
        Property::factory()->soldable()->count(30)->create();

        $perPage = 25;
        $page = 2;

        $response = $this->getJson("/api/properties?per_page=$perPage&page=$page");

        $response->assertStatus(200)
            ->assertJsonPath('total', 30)
            ->assertJsonPath('current_page', $page)
            ->assertJsonPath('per_page', $perPage)
            ->assertJsonCount(5, 'data');
    }

    public function testFiltersPropertiesByProvince()
    {
        $targetProvince = 'Bangkok';
        Property::factory()->soldable()->create(['province' => $targetProvince]);
        Property::factory()->soldable()->create(['province' => 'Nongkhai']);

        $response = $this->getJson("/api/properties?province=$targetProvince");

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'province']
                ]
            ])
            ->assertJsonPath('data.0.province', $targetProvince);
    }

    public function testFiltersPropertiesByCountry()
    {
        $targetCountry = 'Malaysia';
        Property::factory()->soldable()->create(['country' => $targetCountry]);
        Property::factory()->soldable()->create(['country' => 'Thailand']);

        $response = $this->getJson("/api/properties?country=$targetCountry");

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'country']
                ]
            ])
            ->assertJsonPath('data.0.country', $targetCountry);
    }

    public function testSortsPropertiesByPriceAscending()
    {
        Property::factory()->soldable()->create(['price' => '50000.00']);
        Property::factory()->soldable()->create(['price' => '20000.00']);
        Property::factory()->soldable()->create(['price' => '70000.00']);

        $response = $this->getJson('/api/properties?sort_by=price&sort_order=asc');

        $response->assertStatus(200)
            ->assertJsonPath('data.0.price', '20000.00')
            ->assertJsonPath('data.1.price', '50000.00')
            ->assertJsonPath('data.2.price', '70000.00');
    }

    public function testSortsPropertiesByPriceDescending()
    {
        Property::factory()->soldable()->create(['price' => '50000.00']);
        Property::factory()->soldable()->create(['price' => '20000.00']);
        Property::factory()->soldable()->create(['price' => '70000.00']);

        $response = $this->getJson('/api/properties?sort_by=price&sort_order=desc');

        $response->assertStatus(200)
            ->assertJsonPath('data.0.price', '70000.00')
            ->assertJsonPath('data.1.price', '50000.00')
            ->assertJsonPath('data.2.price', '20000.00');
    }

    public function testSearchesPropertiesByTitle()
    {
        Property::factory()->soldable()->create(['title' => 'Beautiful House in Bangkok']);
        Property::factory()->soldable()->create(['title' => 'Luxury Condo in Pattaya']);
        Property::factory()->soldable()->create(['title' => 'Cozy Apartment in Chiang Mai']);

        $response = $this->getJson("/api/properties?search=House");

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Beautiful House in Bangkok');
    }

    public function testFiltersPropertiesWithCombinedCriteria()
    {
        Property::factory()->soldable()->create([
            'title' => 'Luxury House in Bangkok',
            'province' => 'Bangkok',
            'country' => 'Thailand',
            'price' => 50000
        ]);

        Property::factory()->soldable()->create([
            'title' => 'Luxury House in Chiang Mai',
            'province' => 'Chiang Mai',
            'country' => 'Thailand',
            'price' => 60000
        ]);

        Property::factory()->soldable()->create([
            'title' => 'Luxury Condo in Chiang Mai',
            'province' => 'Chiang Mai',
            'country' => 'Thailand',
            'price' => 70000
        ]);

        Property::factory()->soldable()->create([
            'title' => 'Luxury House in Kuala Lumpur',
            'province' => 'Kuala Lumpur',
            'country' => 'Malaysia',
            'price' => 80000
        ]);

        $queryParams = http_build_query([
            'search' => 'Luxury House',
            'country' => 'Thailand',
            'sort_by' => 'price',
            'sort_order' => 'desc'
        ]);

        $response = $this->getJson("/api/properties?$queryParams");

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.country', 'Thailand')
            ->assertJsonPath('data.1.country', 'Thailand')
            ->assertJsonPath('data.0.title', 'Luxury House in Chiang Mai')
            ->assertJsonPath('data.1.title', 'Luxury House in Bangkok')
            ->assertJsonPath('data.0.price', '60000.00')
            ->assertJsonPath('data.1.price', '50000.00');
    }
}
