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
            INSERT INTO user (userName, email, token, salt, passwordHash, isAuthorized)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "sssssi", // Типы: 5 строк (varchar) + 1 целое
            $data['userName'],
            $data['email'],
            $data['token'],
            $data['salt'],
            $data['passwordHash'],
            $data['isAuthorized']
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
            SET 
                userName = ?, 
                email = ?, 
                token = ?, 
                salt = ?, 
                passwordHash = ?, 
                isAuthorized = ?
            WHERE idUser = ?
        ");
        $stmt->bind_param(
            "sssssii", // Типы: 5 строк + 2 целых
            $data['userName'],
            $data['email'],
            $data['token'],
            $data['salt'],
            $data['passwordHash'],
            $data['isAuthorized'],
            $data['idUser']
        );
        return $stmt->execute();
    }

    public function read(array $conditions): array
    {
        if (empty($conditions)) {
            return $this->getAll();
        }
        $query = "SELECT * FROM user WHERE ";
        $whereClauses = [];
        $types = '';
        $values = [];
        foreach ($conditions as $field => $value) {
            $whereClauses[] = "$field = ?";
            $types .= $this->getParamType($value);
            $values[] = $value;
        }
        $query .= implode(' AND ', $whereClauses);
        $stmt = $this->connection->prepare($query);
        if (!empty($values)) {
            $stmt->bind_param($types, ...$values);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    private function getParamType($value): string
    {
        if (is_int($value)) {
            return 'i';
        } elseif (is_float($value)) {
            return 'd';
        } else {
            return 's';
        }
    }

    public function updateToken(int $id, string $token): bool
    {
        $stmt = $this->connection->prepare("
            UPDATE user 
            SET token = ? 
            WHERE idUser = ?
        ");
        $stmt->bind_param("si", $token, $id);
        return $stmt->execute();
    }

    public function getByToken(string $token): object|null
    {
        $stmt = $this->connection->prepare("
            SELECT * FROM user WHERE token = ?
        ");
        $stmt->bind_param("s", $token); // Тип: строка
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object() ?? null;
    }

    public function getByRememberToken(string $token): ?array
    {
        $stmt = $this->connection->prepare("
        SELECT * FROM user 
        WHERE remember_token = ?
    ");
        $stmt->bind_param("s", hash('sha256', $token));
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateRememberToken(int $userId, ?string $token): bool
    {
        $stmt = $this->connection->prepare("
        UPDATE user 
        SET remember_token = ?
        WHERE idUser = ?
    ");
        $hashedToken = $token ? hash('sha256', $token) : null;
        $stmt->bind_param("si", $hashedToken, $userId);
        return $stmt->execute();
    }

    public function getAll(): array
    {
        $result = $this->connection->query("SELECT * FROM user");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}