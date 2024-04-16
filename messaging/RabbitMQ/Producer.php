<?php

namespace Messaging\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class Producer
{
    protected AMQPStreamConnection $connection;
    protected AMQPChannel $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            getenv('RABBITMQ_HOST'),
            getenv('RABBITMQ_PORT'),
            getenv('RABBITMQ_USER'),
            getenv('RABBITMQ_PASS')
        );
        $this->channel = $this->connection->channel();
    }

    public function sendMessage($queueName, $message)
    {
        $this->channel->queue_declare($queueName, false, true, false, false);
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, '', $queueName);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
