<?php

namespace App\Models;

use DateTime;

class Attendee
{
    public int $id;
    public string $name;
    public string $email;
    public string $eventId;
    public DateTime $createdAt;

    public function __construct(int $id, string $name, string $email, string $eventId, DateTime $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->eventId = $eventId;
        $this->createdAt = $createdAt;
    }
}
