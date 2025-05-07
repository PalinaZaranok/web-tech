<?php

namespace models;

class User
{
    private int $idUser;
    private string $userName;
    private string $email;
    private string $userMovies;

    public function getIdUser(): int
    {
        return $this->idUser;
    }
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }
    public function getUserName(): string
    {
        return $this->userName;
    }
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }
    public function getUserMovies(): string
    {
        return $this->userMovies;
    }
    public function setUserMovies(string $userMovies): void
    {
        $this->userMovies = $userMovies;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}