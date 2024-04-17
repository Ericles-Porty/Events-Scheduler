<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\LoggerService;

class PostService
{
    private PostRepository $postRepository;
    private MessageService $messageService;
    private LoggerService $loggerService;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
        $this->messageService = new MessageService();
        $this->loggerService = new LoggerService();
    }

    public function getPosts(): array
    {
        try {
            $posts = $this->postRepository->all();
        } catch (\Throwable $th) {

            $this->loggerService->send(
                'post_all',
                'error',
                'Erro ao buscar posts no banco de dados',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao buscar posts no banco de dados');
        }

        try {
            $message = json_encode($posts);
            $this->messageService->sendMessageToQueue('posts_listed', $message);

            $this->loggerService->send('post_all', 'info', 'Posts listados', $posts);

            return $posts;
        } catch (\Throwable $th) {
            $this->loggerService->send(
                'post_all',
                'error',
                'Erro ao enviar mensagem para a fila',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao enviar mensagem para a fila');
        }
    }

    public function getPostById($id): Post | null
    {
        try {
            $post = $this->postRepository->find($id);
        } catch (\Throwable $th) {

            $this->loggerService->send(
                'post_get',
                'error',
                'Erro ao buscar post no banco de dados',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao buscar post no banco de dados');
        }

        try {
            if (!$post) {
                $message = json_encode(['id' => $id]);

                $this->messageService->sendMessageToQueue('post_not_found', $message);

                $this->loggerService->send('post_get', 'info', 'Post não encontrado', ['id' => $id]);

                return null;
            }

            $message = json_encode($post->toArray());

            $this->messageService->sendMessageToQueue('post_listed', $message);

            $this->loggerService->send('post_get', 'info', 'Post encontrado', $post->toArray());

            return $post;
        } catch (\Throwable $th) {
            $this->loggerService->send(
                'post_get',
                'error',
                'Erro ao enviar mensagem para a fila',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao enviar mensagem para a fila');
        }
    }

    public function createPost(Post $post): Post
    {
        try {
            $post = $this->postRepository->create($post);
        } catch (\Throwable $th) {

            $this->loggerService->send(
                'post_new',
                'error',
                'Erro ao criar post no banco de dados',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao criar post no banco de dados');
        }

        try {
            $message = json_encode($post->toArray());
            $this->messageService->sendMessageToQueue('post_new', $message);

            $this->loggerService->send('post_new', 'info', 'Post criado', $post->toArray());

            return $post;
        } catch (\Throwable $th) {

            $this->loggerService->send(
                'post_new',
                'error',
                'Erro ao enviar mensagem para a fila',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao enviar mensagem para a fila');
        }
    }

    public function updatePost($id, Post $updatedPost): Post
    {
        try {
            $post = $this->postRepository->find($id);
        } catch (\Throwable $th) {

            $this->loggerService->send(
                'post_updt',
                'error',
                'Erro ao buscar post no banco de dados na atualização',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao buscar post no banco de dados');
        }

        try {
            if (!$post) {
                $message = json_encode(['id' => $id]);

                $this->messageService->sendMessageToQueue('post_not_found', $message);

                $this->loggerService->send(
                    'post_updt',
                    'info',
                    'Post não encontrado',
                    ['id' => $id]
                );

                return null;
            }

            $updatedPost = $this->postRepository->update($id, $updatedPost);

            $message = json_encode($updatedPost->toArray());

            $this->messageService->sendMessageToQueue('post_updated', $message);

            $this->loggerService->send(
                'post_updt',
                'info',
                'Post atualizado',
                $updatedPost->toArray()
            );

            return $post;
        } catch (\Throwable $th) {

            $this->loggerService->send(
                'post_updt',
                'error',
                'Erro ao enviar mensagem para a fila',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao enviar mensagem para a fila');
        }
    }

    public function deletePost($id): Post | null
    {
        try {
            $post = $this->postRepository->find($id);
        } catch (\Throwable $th) {
            $this->loggerService->send(
                'post_del',
                'error',
                'Erro ao deletar post no banco de dados',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao deletar post no banco de dados');
        }
        try {
            if (!$post) {
                $message = json_encode(['id' => $id]);

                $this->messageService->sendMessageToQueue('post_not_found', $message);

                $this->loggerService->send(
                    'post_del',
                    'info',
                    'Post não encontrado',
                    ['id' => $id]
                );

                return null;
            }

            $this->postRepository->delete($id);

            $message = json_encode($post->toArray());

            $this->messageService->sendMessageToQueue('post_deleted', $message);

            $this->loggerService->send(
                'post_del',
                'info',
                'Post deletado',
                $post->toArray()
            );

            return $post;
        } catch (\Throwable $th) {
            throw new \Exception('Erro ao deletar post');
        }
    }
}
