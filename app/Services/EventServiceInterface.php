<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Event;

interface EventServiceInterface
{
    public function getEvents(): array;

    public function getEvent(string $id): ?Event;

    public function getEventBySlug(string $slug): ?Event;

    public function createEvent(Event $event): Event;
}
