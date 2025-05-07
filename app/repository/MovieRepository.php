<?php
namespace repository;

require_once 'EntityManager.php';

class MovieRepository extends EntityManager
{
    public function getById(int $id): object|null
    {
        $stmt = $this->connection->prepare("
            SELECT * FROM movies WHERE idMovie = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object() ?? null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->connection->prepare("
            INSERT INTO movies (title, rating, poster, genre)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "sdss",
            $data['title'],
            $data['rating'],
            $data['poster'],
            $data['genre']
        );
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare("
            DELETE FROM movies WHERE idMovie = ?
        ");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function update(array $data): bool
    {
        $stmt = $this->connection->prepare("
            UPDATE movies 
            SET title = ?, rating = ?, poster = ?, genre = ? 
            WHERE idMovie = ?
        ");
        $stmt->bind_param(
            "sdssi",
            $data['title'],
            $data['rating'],
            $data['poster'],
            $data['genre'],
            $data['idMovie']
        );
        return $stmt->execute();
    }

    public function getAll(): array
    {
        $result = $this->connection->query("SELECT * FROM movies");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}