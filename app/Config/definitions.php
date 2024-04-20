<?php

namespace App\Config;

use DI;
use App\Databases\PostgresDatabase;
use App\Services\LoggerService;
use App\Services\LoggerServiceInterface;
use App\Services\PostService;
use App\Services\PostServiceInterface;

return [
    PostgresDatabase::class => new PostgresDatabase(
        $host = 'db', // Container name in docker-compose.yml
        $dbName = getenv('POSTGRES_DB'),
        $username = getenv('POSTGRES_USER'),
        $password = getenv('POSTGRES_PASSWORD'),
    ),
    PostServiceInterface::class => DI\autowire(PostService::class),
    // LoggerServiceInterface::class => \DI\create(LoggerService::class),
];
