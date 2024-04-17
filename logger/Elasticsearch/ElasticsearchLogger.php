<?php

namespace Logger\Elasticsearch;

use Elastic\Elasticsearch\ClientBuilder;
use Psr\Log\LoggerInterface;

class ElasticsearchLogger implements LoggerInterface
{
    private $client;

    public function __construct()
    {
        $host = 'elasticsearch'; // Container name in docker-compose.yml
        $port = getenv('ELASTICSEARCH_HTTP_PORT') ?: 9200;
        $this->client = ClientBuilder::create()
            ->setHosts(["$host:$port"])
            ->build();
    }

    public function send(string $index, string $level, string $message, array $data = []): void
    {
        $this->client->index([
            'index' => $index,
            'body' => [
                'message' => $message,
                'timestamp' => date('Y-m-d H:i:s'),
                'level' => $level,
                'data' => $data
            ]
        ]);
    }

    public function emergency(string|\Stringable $message, array $context = []): void
    {
        $this->send('emergency', 'emergency', $message, $context);
    }

    public function alert(string|\Stringable  $message, array $context = []): void
    {
        $this->send('alert', 'alert', $message, $context);
    }

    public function critical(string|\Stringable $message, array $context = []): void
    {
        $this->send('critical', 'critical', $message, $context);
    }

    public function error(string|\Stringable $message, array $context = []): void
    {
        $this->send('error', 'error', $message, $context);
    }

    public function warning(string|\Stringable $message, array $context = []): void
    {
        $this->send('warning', 'warning', $message, $context);
    }

    public function notice(string|\Stringable $message, array $context = []): void
    {
        $this->send('notice', 'notice', $message, $context);
    }

    public function info(string|\Stringable $message, array $context = []): void
    {
        $this->send('info', 'info', $message, $context);
    }

    public function debug(string|\Stringable $message, array $context = []): void
    {
        $this->send('debug', 'debug', $message, $context);
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $this->send('log', $level, $message, $context);
    }
}
