<?php

declare(strict_types=1);

namespace App\Models;

class Character
{
    private int $id;
    private string $name;
    private string $status;
    private string $species;
    private string $gender;
    private string $location;
    private string $image;

    public function __construct(
        int    $id,
        string $name,
        string $status,
        string $species,
        string $gender,
        string $location,
        string $image
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->species = $species;
        $this->gender = $gender;
        $this->location = $location;
        $this->image = $image;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getSpecies(): string
    {
        return $this->species;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}