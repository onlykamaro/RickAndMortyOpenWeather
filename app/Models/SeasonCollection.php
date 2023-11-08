<?php

declare(strict_types=1);

namespace App\Models;

class SeasonCollection
{
    private array $seasons;

    public function addSeason(Season $season): void
    {
        $this->seasons[] = $season;
    }

    public function getSeasons(): array
    {
        return $this->seasons;
    }
}