<?php

namespace App\Services;

use Logger\Elasticsearch\ElasticsearchLogger;

class LoggerService implements LoggerServiceInterface
{

    public function __construct(
        private ElasticsearchLogger $logger
    ) {
    }

    public function send(string $index, string $level, string $message, array $data = []): void
    {
        $this->logger->send($index, $level, $message, $data);
    }
}
