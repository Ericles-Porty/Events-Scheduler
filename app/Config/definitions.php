<?php

namespace App\Config;

use DI;
use App\Databases\PostgresDatabase;
use App\Repositories\EventRepository;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Services\EventService;
use App\Services\EventServiceInterface;
use App\Services\LoggerService;
use App\Services\LoggerServiceInterface;
use App\Services\PostService;
use App\Services\PostServiceInterface;
use Logger\Elasticsearch\ElasticsearchLogger;
use Rakit\Validation\Validator;

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
    Validator::class => new Validator,
    LoggerServiceInterface::class => \DI\autowire(LoggerService::class),
    EventServiceInterface::class => DI\autowire(EventService::class),
    EventRepositoryInterface::class => DI\autowire(EventRepository::class),
    PostServiceInterface::class => DI\autowire(PostService::class),
    PostRepositoryInterface::class => DI\autowire(PostRepository::class),
];
