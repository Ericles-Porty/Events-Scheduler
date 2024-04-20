<?php

namespace App\Config;

use DI;
use App\Databases\PostgresDatabase;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Services\LoggerService;
use App\Services\LoggerServiceInterface;
use App\Services\PostService;
use App\Services\PostServiceInterface;
use Logger\Elasticsearch\ElasticsearchLogger;

return [
    ElasticsearchLogger::class => new ElasticsearchLogger(
        $host = 'elasticsearch', // Container name in docker-compose.yml
        $port = getenv('ELASTICSEARCH_HTTP_PORT') ?: 9200,
    ),
    PostgresDatabase::class => new PostgresDatabase(
        $host = 'db', // Container name in docker-compose.yml
        $dbName = getenv('POSTGRES_DB'),
        $username = getenv('POSTGRES_USER'),
        $password = getenv('POSTGRES_PASSWORD'),
    ),
    PostServiceInterface::class => DI\autowire(PostService::class),
    PostRepositoryInterface::class => DI\autowire(PostRepository::class),
    LoggerServiceInterface::class => \DI\autowire(LoggerService::class),
];
