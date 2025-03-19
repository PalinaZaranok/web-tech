<?php

namespace repository;

use mysqli;

class EntityManager
{
    private $configPath;
    private $connection;

    private function __construct($configPath)
    {
        $this->configPath = $configPath;
        $this->sqlInit();
    }

    private function sqlInit()
    {
        $config = json_decode(file_get_contents($this->configPath), true);
        if ($config === null) {
            die("Ошибка декодирования файла конфигурации.");
        }

        $host = $config['DB_HOST'];
        $user = $config['DB_USER'];
        $password = $config['DB_PASS'];
        $dbname = $config['DB_NAME'];

        $this->connection = new mysqli($host, $user, $password, $dbname);
    }

    private function closeConnection()
    {
        $this->connection->close();
    }

    protected function takeUserData()
    {
        $content = file_get_contents('./.env');

        $lines = explode("\n", $content);
        $config = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                list($key, $value) = explode('=', $line);
                $config[trim($key)] = trim($value);
            }
        }
        return $config;
    }

}