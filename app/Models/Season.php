<?php

declare(strict_types=1);

namespace App\Models;

class Season
{
    private int $seasonId;

    public function __construct(int $seasonId)
    {
        $this->seasonId = $seasonId;
    }

    public function getSeasonId(): int
    {
        return $this->seasonId;
    }
}