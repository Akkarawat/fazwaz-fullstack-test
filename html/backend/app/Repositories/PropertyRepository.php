<?php

namespace App\Repositories;

use App\Models\Property;
use App\Domain\DTOs\PropertyFilterDTO;
use App\Domain\DTOs\PaginationParamsDTO;

class PropertyRepository
{
    public function getProperties(PropertyFilterDTO $filters, PaginationParamsDTO $pagination)
    {
        $query = Property::query();

        $query->where('for_sale', true)->where('sold', false);

        if (!empty($filters->search)) {
            $searchTerm = '%' . $filters->search . '%';
            $query->where('title', 'like', $searchTerm);
        }

        if (!empty($filters->province)) {
            $query->where('province', $filters->province);
        }

        if (!empty($filters->country)) {
            $query->where('country', $filters->country);
        }

        $query->orderBy($filters->sortBy->value, $filters->sortOrder->value);

        return $query->paginate($pagination->perPage, ['*'], 'page', $pagination->page);
    }
}
