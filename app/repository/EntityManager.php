<?php

namespace repository;

use mysqli;

abstract class EntityManager
{
    protected mysqli $connection;

    public function __construct()
    {
        $configPath = __ROOT__ .'\config.json';
        if (file_exists($configPath)) {
            $this->sqlInit(__ROOT__ .'\config.json');
        }
    }

    private function sqlInit(string $configPath): void
    {
        $config = json_decode(file_get_contents($configPath), true);
        if ($config === null) {
            die("Ошибка декодирования файла конфигурации.");
        }

        $host = $config['host'];
        $user = $config['username'];
        $password = $config['password'];
        $dbname = $config['database'];

        $this->connection = new mysqli($host, $user, $password, $dbname);
    }

    public function closeConnection(): void
    {
        $this->connection->close();
    }

    public abstract function getById(int $id): object | null;
    public abstract function create(array $data): bool;
    public abstract function delete(int $id): bool;
    public abstract function update(array $data): bool;
    public abstract function getAll(): array;

}