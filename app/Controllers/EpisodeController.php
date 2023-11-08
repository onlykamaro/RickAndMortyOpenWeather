<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Api;
use App\Response;

class EpisodeController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function show(array $vars): Response
    {
        $id = (int)$vars['id'];

        $episode = $this->api->fetchEpisode($id);

        $getCharacters = $episode->getCharacters()->getCharacters();

        $characters = [];

        foreach ($getCharacters as $character) {
            $characters[] = $this->api->fetchCharacter($character);
        }

        return new Response('episodes/show', [
            'episode' => $episode,
            'characters' => $characters,
            'header' => $episode->getName()
        ]);
    }
}