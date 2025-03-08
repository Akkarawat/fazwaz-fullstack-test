<?php

namespace App\Domain\Enums;

enum PropertyOrderBy: string
{
    case PRICE = 'price';
    case CREATED_AT = 'created_at';

    public static function fromString(?string $value): self
    {
        return match ($value) {
            'price' => self::PRICE,
            default => self::CREATED_AT,
        };
    }
}
