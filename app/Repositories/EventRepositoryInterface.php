<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Event;

interface EventRepositoryInterface
{
    public function all(): array;

    public function find(string $id): ?Event;
    
    public function findBySlug(string $slug): ?Event;

    public function create(Event $event): Event;
}
