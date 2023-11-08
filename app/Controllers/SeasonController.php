<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Api;
use App\Response;

class SeasonController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(): Response
    {
        $seasons = [];
        $s = $this->api->fetchSeasons()->getSeasons();

        foreach ($s as $season) {
            $seasons[] = $season->getSeasonId();
        }

        return new Response(
            'seasons/index',
            [
                'seasons' => $seasons,
                'header' => 'All Seasons'
            ]
        );
    }

    public function show(array $vars): Response
    {
        $id = (int)$vars['id'];

        $episodeCollection = $this->api->fetchEpisodesBySeasonId($id);

        return new Response(
            'seasons/show',
            [
                'episodes' => $episodeCollection->getEpisodes(),
                'header' => 'Season ' . $id
            ]
        );
    }
}
