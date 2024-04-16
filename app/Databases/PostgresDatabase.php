<?php

namespace App\Databases;

use PDO;
use PDOException;

class PostgresDatabase
{
    private $connection;
    public function __construct()
    {
        $host = 'db'; // Container name in docker-compose.yml
        $dbName = getenv('POSTGRES_DB');
        $username = getenv('POSTGRES_USER');
        $password = getenv('POSTGRES_PASSWORD');
        $dsn = "pgsql:host={$host};dbname={$dbName}";
        try {
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro de conexão com o banco de dados: ' . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
