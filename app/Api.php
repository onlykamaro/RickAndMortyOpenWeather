<?php

declare(strict_types=1);

namespace App;

use App\Models\Character;
use App\Models\CharacterCollection;
use App\Models\Episode;
use App\Models\EpisodeCollection;
use App\Models\Season;
use App\Models\SeasonCollection;
use Carbon\Carbon;
use GuzzleHttp\Client;

class Api
{
    private Client $client;

    private const API_URL = 'https://rickandmortyapi.com/api';

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false
        ]);
    }

    public function fetchEpisodes(): EpisodeCollection
    {
        $episodeCollection = new EpisodeCollection();

        $page = 1;

        while (true) {
            $response = $this->client->get(self::API_URL . "/episode?page=$page");

            $data = json_decode((string)$response->getBody());

            foreach ($data->results as $result) {
                $characters = $this->fetchCharacters($result->characters);

                $episodeCollection->addEpisode(new Episode(
                    $result->id,
                    $result->name,
                    Carbon::parse($result->air_date),
                    $result->episode,
                    $characters
                ));
            }

            $page++;

            if ($data->info->next == null) {
                break;
            }
        }

        return $episodeCollection;
    }

    public function fetchEpisode(int $id): Episode
    {
        $response = $this->client->get(self::API_URL . "/episode/{$id}");

        $result = json_decode((string)$response->getBody());

        $characters = $this->fetchCharacters($result->characters);

        return new Episode(
            $result->id,
            $result->name,
            Carbon::parse($result->air_date),
            $result->episode,
            $characters
        );
    }

    public function fetchSeasons(): SeasonCollection
    {
        $episodes = $this->fetchEpisodes()->getEpisodes();
        $seasons = [];

        /** @var Episode $episode */
        foreach ($episodes as $episode) {
            $episodeSeason = (int)substr($episode->getEpisode(), 1, 2);
            $seasons[] = [
                'season_id' => $episodeSeason
            ];
        }

        $seasonCollection = new SeasonCollection();

        foreach (array_unique(array_column($seasons, 'season_id')) as $seasonId) {
            $seasonCollection->addSeason(new Season($seasonId));
        }
        return $seasonCollection;
    }

    public function fetchEpisodesBySeasonId(int $seasonId): EpisodeCollection
    {
        $episodes = $this->fetchEpisodes()->getEpisodes();
        $filteredEpisodes = [];

        /** @var Episode $episode */
        foreach ($episodes as $episode) {
            $episodeSeason = (int)substr($episode->getEpisode(), 1, 2);

            if ($episodeSeason === $seasonId) {
                $filteredEpisodes[] = $episode;
            }
        }

        $episodeCollection = new EpisodeCollection();

        foreach ($filteredEpisodes as $episode) {
            $episodeCollection->addEpisode($episode);
        }

        return $episodeCollection;
    }

    public function fetchCharacters(array $value): CharacterCollection
    {
        $characters = new CharacterCollection();

        foreach ($value as $item) {
            $parts = explode("/", $item);
            $characterId = (int)end($parts);

            $characters->addCharacter($characterId);
        }

        return $characters;
    }

    public function fetchCharacter(int $id): Character
    {

        $response = $this->client->get(self::API_URL . "/character/{$id}");

        $result = json_decode((string)$response->getBody());

        return new Character(
            $result->id,
            $result->name,
            $result->status,
            $result->species,
            $result->gender,
            $result->location->name,
            $result->image
        );
    }

    public function searchEpisodes(string $searchPhrase): EpisodeCollection
    {
        $searchPhrase = strtolower($searchPhrase);

        $episodes = $this->fetchEpisodes()->getEpisodes();
        $filteredEpisodes = [];

        /** @var Episode $episode */
        foreach ($episodes as $episode) {
            $episodeName = strtolower($episode->getName());
            $episodeSeason = strtolower($episode->getEpisode());


            if (stripos($episodeName, $searchPhrase) !== false ||
                stripos($episodeSeason, $searchPhrase) !== false
            ) {
                $filteredEpisodes[] = $episode;
            }
        }

        $episodeCollection = new EpisodeCollection();

        foreach ($filteredEpisodes as $episode) {
            $episodeCollection->addEpisode($episode);
        }

        return $episodeCollection;
    }
}