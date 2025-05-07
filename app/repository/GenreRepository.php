<?php
namespace repository;

require_once 'EntityManager.php';

class GenreRepository extends EntityManager
{
    public function getById(int $id): object|null
    {
        $stmt = $this->connection->prepare("
            SELECT * FROM genres WHERE idGenre = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object() ?? null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->connection->prepare("
            INSERT INTO genres (idUser, idMovie)
            VALUES (?, ?)
        ");
        $stmt->bind_param(
            "ii",
            $data['idUser'],
            $data['idMovie']
        );
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare("
            DELETE FROM genres WHERE idGenre = ?
        ");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function update(array $data): bool
    {
        $stmt = $this->connection->prepare("
            UPDATE genres 
            SET idUser = ?, idMovie = ? 
            WHERE idGenre = ?
        ");
        $stmt->bind_param(
            "iii",
            $data['idUser'],
            $data['idMovie'],
            $data['idGenre']
        );
        return $stmt->execute();
    }

    public function getAll(): array
    {
        $result = $this->connection->query("SELECT * FROM genres");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}