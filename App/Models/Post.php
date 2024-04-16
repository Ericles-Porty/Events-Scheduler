<?php

namespace App\Models;

class Post
{
    public int $id;
    public string $title;
    public string $content;

    public function __construct(int $id = 0, string $title = '', string $content = '')
    {
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
}
