<?php

namespace App\Services;

use App\Models\Post;

interface PostServiceInterface
{

    public function getPosts(): array;

    public function getPostById($id): Post | null;

    public function createPost(Post $post): Post;

    public function updatePost($id, Post $updatedPost): Post;

    public function deletePost($id): Post | null;
}
