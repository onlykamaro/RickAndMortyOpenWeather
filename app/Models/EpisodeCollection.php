<?php

declare(strict_types=1);

namespace App\Models;

class EpisodeCollection
{
    private array $episodes;

    public function __construct()
    {
        $this->episodes = [];
    }

    public function addEpisode(Episode $episodes): void
    {
        $this->episodes[] = $episodes;
    }

    public function getEpisodes(): array
    {
        return $this->episodes;
    }
}