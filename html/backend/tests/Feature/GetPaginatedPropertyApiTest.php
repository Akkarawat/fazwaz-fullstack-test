<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Property;

class GetPaginatedPropertyApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_ENDPOINT = '/api/properties';

    private function createProperty(array $overrides = [])
    {
        return Property::factory()->soldable()->create($overrides);
    }

    public function testFetchesPropertiesSuccessfully()
    {
        Property::factory()->count(5)->soldable()->create();

        $response = $this->getJson(self::API_ENDPOINT);

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

        $queryParams = http_build_query(['per_page' => 25, 'page' => 2]);
        $response = $this->getJson(self::API_ENDPOINT . "?$queryParams");

        $response->assertStatus(200)
            ->assertJsonPath('total', 30)
            ->assertJsonPath('current_page', 2)
            ->assertJsonPath('per_page', 25)
            ->assertJsonCount(5, 'data');
    }

    public function testFiltersPropertiesByProvince()
    {
        $targetProvince = 'Bangkok';
        $this->createProperty(['province' => $targetProvince]);
        $this->createProperty(['province' => 'Nongkhai']);

        $queryParams = http_build_query(['province' => $targetProvince]);
        $response = $this->getJson(self::API_ENDPOINT . "?$queryParams");

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.province', $targetProvince);
    }

    public function testFiltersPropertiesByCountry()
    {
        $targetCountry = 'Malaysia';
        $this->createProperty(['country' => $targetCountry]);
        $this->createProperty(['country' => 'Thailand']);

        $queryParams = http_build_query(['country' => $targetCountry]);
        $response = $this->getJson(self::API_ENDPOINT . "?$queryParams");

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.country', $targetCountry);
    }

    public function testSearchesPropertiesByTitle()
    {
        $this->createProperty(['title' => 'Beautiful House in Bangkok']);
        $this->createProperty(['title' => 'Luxury Condo in Pattaya']);
        $this->createProperty(['title' => 'Cozy Apartment in Chiang Mai']);

        $queryParams = http_build_query(['search' => 'House']);
        $response = $this->getJson(self::API_ENDPOINT . "?$queryParams");

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Beautiful House in Bangkok');
    }

    public function testSortsPropertiesByPriceAscending()
    {
        $prices = [50000, 20000, 70000];
        foreach ($prices as $price) {
            $this->createProperty(['price' => $price]);
        }

        $queryParams = http_build_query(['sort_by' => 'price', 'sort_order' => 'asc']);
        $response = $this->getJson(self::API_ENDPOINT . "?$queryParams");

        sort($prices);

        $response->assertStatus(200)
            ->assertJsonPath('data.0.price', number_format($prices[0], 2, '.', ''))
            ->assertJsonPath('data.1.price', number_format($prices[1], 2, '.', ''))
            ->assertJsonPath('data.2.price', number_format($prices[2], 2, '.', ''));
    }

    public function testSortsPropertiesByPriceDescending()
    {
        $prices = [50000, 20000, 70000];
        foreach ($prices as $price) {
            $this->createProperty(['price' => $price]);
        }

        $queryParams = http_build_query(['sort_by' => 'price', 'sort_order' => 'desc']);
        $response = $this->getJson(self::API_ENDPOINT . "?$queryParams");

        rsort($prices);

        $response->assertStatus(200)
            ->assertJsonPath('data.0.price', number_format($prices[0], 2, '.', ''))
            ->assertJsonPath('data.1.price', number_format($prices[1], 2, '.', ''))
            ->assertJsonPath('data.2.price', number_format($prices[2], 2, '.', ''));
    }

    public function testFiltersPropertiesWithCombinedCriteria()
    {
        $this->createProperty([
            'title' => 'Luxury House in Bangkok',
            'province' => 'Bangkok',
            'country' => 'Thailand',
            'price' => 50000
        ]);

        $this->createProperty([
            'title' => 'Luxury House in Chiang Mai',
            'province' => 'Chiang Mai',
            'country' => 'Thailand',
            'price' => 60000
        ]);

        $this->createProperty([
            'title' => 'Luxury Condo in Chiang Mai',
            'province' => 'Chiang Mai',
            'country' => 'Thailand',
            'price' => 70000
        ]);

        $this->createProperty([
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

        $response = $this->getJson(self::API_ENDPOINT . "?$queryParams");

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.price', number_format(60000, 2, '.', ''))
            ->assertJsonPath('data.1.price', number_format(50000, 2, '.', ''))
            ->assertJsonPath('data.0.title', 'Luxury House in Chiang Mai')
            ->assertJsonPath('data.1.title', 'Luxury House in Bangkok');
    }
}
