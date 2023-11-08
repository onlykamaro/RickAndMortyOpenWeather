<?php

declare(strict_types=1);

namespace App\Models;

class CharacterCollection
{
    private array $characters = [];

    public function addCharacter(int $character)
    {
        $this->characters[] = $character;
    }

    public function getCharacters(): array
    {
        return $this->characters;
    }
}
