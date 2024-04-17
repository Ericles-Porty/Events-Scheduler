<?php

namespace App\Repositories;

use App\Databases\PostgresDatabase;

abstract class DbRepository implements RepositoryInterface
{
    protected $connection = null;

    public function __construct()
    {
        $this->connection = (new PostgresDatabase())->getConnection();
    }
}
