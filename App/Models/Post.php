<?php

namespace App\Models;

use App\Database\Database;
use PDO;

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


    public static function getAll(): array
    {
        $database = new Database();

        $pdo = $database->getConnection();

        $stmt = $pdo->query('SELECT id, title, content FROM posts');

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public static function getOne(int $id): Post | null
    {
        $database = new Database();

        $pdo = $database->getConnection();

        $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception('Erro ao buscar post');
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $post = new Post();

        $post->id = $row['id'];
        $post->title = $row['title'];
        $post->content = $row['content'];

        return $post;
    }

    public static function create(Post $post): Post
    {
        $database = new Database();

        $pdo = $database->getConnection();

        $stmt = $pdo->prepare('INSERT INTO posts (title, content) VALUES (:title, :content)');
        $stmt->bindParam(':title', $post->title);
        $stmt->bindParam(':content', $post->content);
        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception('Erro ao inserir post');
        }

        $post->id = $pdo->lastInsertId();

        return $post;
    }

    public static function update(Post $post): Post
    {
        $database = new Database();

        $pdo = $database->getConnection();

        $stmt = $pdo->prepare('UPDATE posts SET title = :title, content = :content WHERE id = :id');
        $stmt->bindParam(':title', $post->title);
        $stmt->bindParam(':content', $post->content);
        $stmt->bindParam(':id', $post->id);
        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception('Erro ao atualizar post');
        }

        return $post;
    }

    public static function delete(int $id): void
    {
        $database = new Database();

        $pdo = $database->getConnection();

        $stmt = $pdo->prepare('DELETE FROM posts WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception('Erro ao deletar post');
        }
    }
}
