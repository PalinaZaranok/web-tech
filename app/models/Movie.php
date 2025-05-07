<?php

namespace models;

use http\Encoding\Stream;

class Movie
{
    private int $idMovie;
    private string  $title;
    private float $rating;
    private string $poster;
    private string $genre;

    public function getToArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'rating' => $this->getRating(),
            'poster' => $this->getPoster(),
            'genre' => $this->getGenre()
        ];
    }

    public function getIdMovie(): int
    {
        return $this->idMovie;
    }
    public function setIdMovie(int $idMovie): void
    {
        $this->idMovie = $idMovie;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function getRating(): float
    {
        return $this->rating;
    }
    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }
    public function getPoster(): string
    {
        return $this->poster;
    }
    public function setPoster(string $poster): void
    {
        $this->poster = $poster;
    }
    public function getGenre(): string
    {
        return $this->genre;
    }
    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }
}