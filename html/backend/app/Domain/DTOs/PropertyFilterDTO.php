<?php

namespace App\Domain\DTOs;

use App\Domain\Enums\PropertyOrderBy;
use App\Domain\Enums\SortOrder;

class PropertyFilterDTO
{
    public ?string $search;
    public ?string $province;
    public ?string $country;
    public PropertyOrderBy $sortBy;
    public SortOrder $sortOrder;

    public function __construct(?string $search, ?string $province, ?string $country, PropertyOrderBy $sortBy, SortOrder $sortOrder)
    {
        $this->search = $search;
        $this->province = $province;
        $this->country = $country;
        $this->sortBy = $sortBy;
        $this->sortOrder = $sortOrder;
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            $data['search'] ?? null,
            $data['province'] ?? null,
            $data['country'] ?? null,
            PropertyOrderBy::fromString($data['sort_by'] ?? 'created_at'),
            SortOrder::fromString($data['sort_order'] ?? 'desc')
        );
    }
}
