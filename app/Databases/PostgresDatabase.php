<?php

declare(strict_types=1);

namespace App\Databases;

use PDO;
use PDOException;

class PostgresDatabase
{
    private PDO $connection;

    public function __construct(
        private string $host,
        private string $dbName,
        private string $username,
        private string $password
    ) {

        $dsn = "pgsql:host={$this->host};dbname={$this->dbName}";
        try {
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro de conexão com o banco de dados: ' . $e->getMessage();
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
