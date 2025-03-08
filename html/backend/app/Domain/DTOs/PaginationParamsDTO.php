<?php

namespace App\Domain\DTOs;

class PaginationParamsDTO
{
    public int $page;
    public int $perPage;

    public function __construct(int $page, int $perPage)
    {
        $this->page = max(1, $page);
        $this->perPage = max(1, $perPage);
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            (int) ($data['page'] ?? 1),
            (int) ($data['per_page'] ?? 10)
        );
    }
}
