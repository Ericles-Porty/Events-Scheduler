<?php

namespace App\Services;

use Logger\Elasticsearch\ElasticsearchLogger;

class LoggerService
{
    private ElasticsearchLogger $loggerClient;

    public function __construct()
    {
        $this->loggerClient = new ElasticsearchLogger;
    }

    public function send(string $index, string $level, string $message, array $data = []): void
    {
        $this->loggerClient->send($index, $level, $message, $data);
    }
}
