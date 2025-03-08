<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PropertyRepository;
use App\Domain\DTOs\PropertyFilterDTO;
use App\Domain\DTOs\PaginationParamsDTO;

class PropertyController extends Controller
{
    protected $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function getProperties(Request $request)
    {
        $filters = PropertyFilterDTO::fromRequest($request->query());
        $paginationParams = PaginationParamsDTO::fromRequest($request->query());

        $pagination = $this->propertyRepository->getProperties($filters, $paginationParams);

        return response()->json([
            'data' => $pagination->items(),
            'total' => $pagination->total(),
            'current_page' => $pagination->currentPage(),
            'per_page' => $pagination->perPage(),
        ]);
    }
}
