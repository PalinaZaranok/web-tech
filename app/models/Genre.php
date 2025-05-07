<?php

declare(strict_types=1);
namespace models;

class Genre
{
    private int $idGenre;
    private int $idUser;
    private int $idMovie;

    public function getIdGenre(): int
    {
        return $this->idGenre;
    }
    public function setIdGenre(int $idGenre): void
    {
        $this->idGenre = $idGenre;
    }
    public function getIdUser(): int
    {
        return $this->idUser;
    }
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }
    public function getIdMovie(): int
    {
        return $this->idMovie;
    }
    public function setIdMovie(int $idMovie): void
    {
        $this->idMovie = $idMovie;
    }
}