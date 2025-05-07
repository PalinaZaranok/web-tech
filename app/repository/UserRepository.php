<?php
namespace repository;

require_once 'EntityManager.php';

class UserRepository extends EntityManager
{
    public function getById(int $id): object|null
    {
        $stmt = $this->connection->prepare("
            SELECT * FROM user WHERE idUser = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object() ?? null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->connection->prepare("
            INSERT INTO user (userName, email, userMovies)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param(
            "sss",
            $data['userName'],
            $data['email'],
            $data['userMovies']
        );
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare("
            DELETE FROM user WHERE idUser = ?
        ");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function update(array $data): bool
    {
        $stmt = $this->connection->prepare("
            UPDATE user 
            SET userName = ?, email = ?, userMovies = ? 
            WHERE idUser = ?
        ");
        $stmt->bind_param(
            "sssi",
            $data['userName'],
            $data['email'],
            $data['userMovies'],
            $data['idUser']
        );
        return $stmt->execute();
    }

    public function getAll(): array
    {
        $result = $this->connection->query("SELECT * FROM user");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}