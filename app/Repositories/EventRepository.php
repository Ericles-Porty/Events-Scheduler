<?php

namespace App\Repositories;

use App\Databases\PostgresDatabase;
use App\Models\Event;
use PDO;

class EventRepository implements EventRepositoryInterface
{
    private PDO $connection;

    public function __construct(
        private PostgresDatabase $database
    ) {
        $this->connection = $database->getConnection();
    }

    public function all(): array
    {
        $stmt = $this->connection->query('SELECT * FROM events');

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = $rows;

        return $events;
    }

    public function find(string $id): ?Event
    {

        $stmt = $this->connection->prepare('SELECT * FROM events WHERE id = :id');
        $stmt->bindParam(':id', $id);

        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception('Erro ao buscar evento');
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $event = Event::fromArray($row);

        return $event;
    }

    public function findBySlug(string $slug): ?Event
    {

        $stmt = $this->connection->prepare('SELECT * FROM events WHERE slug = :slug');
        $stmt->bindParam(':slug', $slug);

        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception('Erro ao buscar evento');
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $event = Event::fromArray($row);

        return $event;
    }

    public function create(Event $event): Event
    {

        $event->id = uniqid();
        

        $stmt = $this->connection->prepare('INSERT INTO events (id, title, slug, details, maximum_attendees) VALUES (:id, :title, :slug, :details, :maximum_attendees)');

        $stmt->bindParam(':id', $event->id);
        $stmt->bindParam(':title', $event->title);
        $stmt->bindParam(':slug', $event->slug);
        $stmt->bindParam(':details', $event->details);
        $stmt->bindParam(':maximum_attendees', $event->maximumAttendees);

        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception('Erro ao criar evento');
        }


        return $event;
    }
}
