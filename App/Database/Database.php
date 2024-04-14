<?php
// app/Database/Database.php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private $host = 'db';
    private $dbName = 'posts';
    private $username = 'postgres';
    private $password = 'postgres';
    private $connection;

    public function __construct()
    {
        $dsn = "pgsql:host={$this->host};dbname={$this->dbName}";

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password);
            // Configuração adicional, se necessário
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create table posts if not exists
           
            
        } catch (PDOException $e) {
            echo 'Erro de conexão: ' . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
