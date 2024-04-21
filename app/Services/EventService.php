<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\EventRepositoryInterface;

class EventService implements EventServiceInterface
{
    public function __construct(
        private EventRepositoryInterface $repository
    ) {
    }

    public function getEvents(): array
    {
        $events = $this->repository->all();

        $events = array_map(function (array $event) {
            return Event::fromArray($event)->toJson();
        }, $events);

        return $events;
    }

    public function getEvent(string $id): ?Event
    {
        return $this->repository->find($id);
    }

    public function createEvent(Event $event): Event
    {
        $slugGenerator = require ROOT_PATH . '/app/Utils/generateSlug.php';

        $event->slug = $slugGenerator($event->title);

        try {
            $event = $this->repository->create($event);

            return $event;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
