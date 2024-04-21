<?php

namespace App\Models;

use DateTime;

class Checkin
{
    public int $id;
    public string $attendeeId;
    public DateTime $createdAt;

    public function __construct(int $id, string $attendeeId, DateTime $createdAt)
    {
        $this->id = $id;
        $this->attendeeId = $attendeeId;
        $this->createdAt = $createdAt;
    }
}
