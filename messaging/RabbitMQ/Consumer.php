<?php

namespace Messaging\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;

class Consumer
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

    public function consumeMessage($queueName, $callback)
    {
        $this->channel->queue_declare($queueName, false, true, false, false);

        $this->channel->basic_consume(
            $queueName,
            '', // consumer tag - Identifier for the consumer, valid within the current channel. just string
            false, // no local - TRUE: the server will not send messages to the connection that published them
            true, // no ack - send a proper acknowledgment from the worker, once we're done with a task
            false, // exclusive - queues may only be accessed by the current connection
            false, // no wait - TRUE: the server will not respond to the method
            $callback
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
