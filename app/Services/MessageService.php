<?php

namespace App\Services;

use Messaging\RabbitMQ\Producer;

class MessageService
{
    protected Producer $messageProducer;

    public function __construct()
    {
        $this->messageProducer = new Producer();
    }

    public function sendMessageToQueue($queueName, $message)
    {
        $this->messageProducer->sendMessage($queueName, $message);
    }
}
