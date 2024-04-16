<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;

class PostService
{
    private PostRepository $postRepository;
    private MessageService $messageService;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
        $this->messageService = new MessageService();
    }

    public function getPosts(): array
    {
        try {
            $posts = $this->postRepository->all();

            $message = json_encode($posts);

            $this->messageService->sendMessageToQueue('posts_listed', $message);

            return $posts;
        } catch (\Throwable $th) {
            throw new \Exception('Erro ao buscar posts');
        }
    }

    public function getPostById($id): Post | null
    {
        try {
            $post = $this->postRepository->find($id);

            if (!$post) {
                $message = json_encode(['id' => $id]);

                $this->messageService->sendMessageToQueue('post_not_found', $message);

                return null;
            }

            $message = json_encode($post->toArray());

            $this->messageService->sendMessageToQueue('post_listed', $message);

            return $post;
        } catch (\Throwable $th) {
            throw new \Exception('Erro ao buscar post');
        }
    }

    public function createPost(Post $post): Post
    {
        try {
            $post = $this->postRepository->create($post);

            $message = json_encode($post->toArray());

            $this->messageService->sendMessageToQueue('post_created', $message);

            return $post;
        } catch (\Throwable $th) {
            throw new \Exception('Erro ao criar post');
        }
    }

    public function updatePost($id, Post $updatedPost): Post
    {
        try {
            $post = $this->postRepository->find($id);

            if (!$post) {
                $message = json_encode(['id' => $id]);

                $this->messageService->sendMessageToQueue('post_not_found', $message);

                return null;
            }

            $updatedPost = $this->postRepository->update($id, $updatedPost);

            $message = json_encode($updatedPost->toArray());

            $this->messageService->sendMessageToQueue('post_updated', $message);

            return $post;
        } catch (\Throwable $th) {
            throw new \Exception('Erro ao atualizar post');
        }
    }

    public function deletePost($id): Post | null
    {
        try {
            $post = $this->postRepository->find($id);

            if (!$post) {
                $message = json_encode(['id' => $id]);

                $this->messageService->sendMessageToQueue('post_not_found', $message);

                return null;
            }

            $this->postRepository->delete($id);

            $message = json_encode($post->toArray());

            $this->messageService->sendMessageToQueue('post_deleted', $message);

            return $post;
        } catch (\Throwable $th) {
            throw new \Exception('Erro ao deletar post');
        }
    }
}
