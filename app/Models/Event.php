<?php

declare(strict_types=1);

namespace App\Models;

class Event
{
    public string $id;
    public string $title;
    public string $slug;
    public ?string $details;
    public ?int $maximumAttendees;

    public function __construct(string $id = "", string $title = "",  string $slug = "", ?string $details = null, ?int $maximumAttendees = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
        $this->details = $details;
        $this->maximumAttendees = $maximumAttendees;
    }

    public static function fromArray(array $data): Event
    {
        return new Event(
            $data['id'] ?? '',
            $data['title'],
            $data['slug'] ?? '',
            $data['details'] ?? null,
            $data['maximum_attendees'] ?? null
        );
    }

    public function toJson(): string
    {
        $json = [];
        $json['id'] = $this->id;
        $json['title'] = $this->title;
        $json['slug'] = $this->slug;
        if ($this->details !== null) {
            $json['details'] = $this->details;
        }
        if ($this->maximumAttendees !== null) {
            $json['maximum_attendees'] = $this->maximumAttendees;
        }
        return json_encode($json);
    }
}
