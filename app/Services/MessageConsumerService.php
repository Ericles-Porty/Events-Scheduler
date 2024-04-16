<?php

namespace App\Services;

use Messaging\RabbitMQ\Consumer;

class MessageConsumerService
{
    protected Consumer $messageConsumer;

    public function __construct()
    {
        $this->messageConsumer = new Consumer();
    }

    public function consumeMessagesFromQueue($queueName, callable $callback)
    {
        $this->messageConsumer->consumeMessage($queueName, $callback);
    }
}
