<?php

namespace App\Models;

class Post
{
    public int $id;
    public string $title;
    public string $content;

    public function __construct(
        int $id = 0,
        string $title = '',
        string $content = ''
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content
        ];
    }

    public static function fromArray(array $data): Post
    {
        if (!isset($data['id'])) {
            $data['id'] = 0;
        }

        return new Post($data['id'], $data['title'], $data['content']);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public static function fromJson(string $json): Post
    {
        $data = json_decode($json, true);

        return new Post($data['id'], $data['title'], $data['content']);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public static function validate($post): bool
    {
        if (strlen($post->title) < 3) {
            return false;
        }

        if (strlen($post->content) < 5) {
            return false;
        }

        return true;
    }
}
