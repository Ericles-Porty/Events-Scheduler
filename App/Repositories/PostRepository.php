<?php

namespace App\Repositories;

use App\Models\Post;

use PDO;

class PostRepository extends DbRepository
{
    public function all(): array
    {
        $stmt = $this->connection->query('SELECT * FROM posts');

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];

        foreach ($rows as $row) {
            $post = Post::fromArray($row);

            array_push($posts, $post);
        }

        return $posts;
    }

    public function find($id): Post | null
    {
        $stmt = $this->connection->prepare('SELECT * FROM posts WHERE id = :id');
        $stmt->bindParam(':id', $id);

        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception('Erro ao buscar post');
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $post = Post::fromArray($row);

        return $post;
    }

    public function create($post): Post
    {
        $stmt = $this->connection->prepare('INSERT INTO posts (title, content) VALUES (:title, :content)');
        $stmt->bindParam(':title', $post->title);
        $stmt->bindParam(':content', $post->content);

        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception('Erro ao criar post');
        }

        $post->id = $this->connection->lastInsertId();

        return $post;
    }

    public function update($id, $post): Post
    {
        $stmt = $this->connection->prepare('UPDATE posts SET title = :title, content = :content WHERE id = :id');
        $stmt->bindParam(':title', $post->title);
        $stmt->bindParam(':content', $post->content);
        $stmt->bindParam(':id', $id);

        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception('Erro ao atualizar post');
        }

        return $post;
    }

    public function delete($id): void
    {
        $stmt = $this->connection->prepare('DELETE FROM posts WHERE id = :id');
        $stmt->bindParam(':id', $id);

        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception('Erro ao deletar post');
        }
    }
}
