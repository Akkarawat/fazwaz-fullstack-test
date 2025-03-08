<?php

namespace App\Domain\Enums;

enum SortOrder: string
{
    case ASC = 'asc';
    case DESC = 'desc';

    public static function fromString(?string $value): self
    {
        return match ($value) {
            'asc' => self::ASC,
            default => self::DESC,
        };
    }
}
