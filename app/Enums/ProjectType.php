<?php

declare(strict_types=1);

namespace App\Enums;

enum ProjectType: string
{
    case AGILE = 'agile';
    case WATERFALL = 'waterfall';
    case SIMPLE = 'simple';

    public function label(): string
    {
        return match ($this) {
            self::AGILE => 'Agile',
            self::WATERFALL => 'Waterfall',
            self::SIMPLE => 'Simple',
        };
    }
}
