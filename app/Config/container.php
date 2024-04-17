<?php

namespace App\Config;

use App\Services\LoggerService;
use App\Services\LoggerServiceInterface;
use App\Services\PostService;
use App\Services\PostServiceInterface;

return [
    LoggerServiceInterface::class => \DI\create(LoggerService::class),
    PostServiceInterface::class => \DI\create(PostService::class),
];
