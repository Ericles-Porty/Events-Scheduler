<?php

namespace App\Services;

use App\Models\Post;

interface PostServiceInterface
{

    public function getPosts(): array;

    public function getPostById($id): Post | null;

    public function createPost(Post $post): Post;

    public function updatePost($id, Post $post): Post;

    public function deletePost($id): void;
}
