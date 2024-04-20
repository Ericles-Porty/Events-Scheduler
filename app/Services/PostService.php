<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepositoryInterface;

class PostService implements PostServiceInterface
{
    private MessageService $messageService;

    public function __construct(
        private PostRepositoryInterface $postRepository,
        private LoggerServiceInterface $loggerService
    ) {
        $this->messageService = new MessageService();
    }

    public function getPosts(): array
    {
        try {
            $posts = $this->postRepository->all();

            return $posts;
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
    }

    public function getPostById($id): Post | null
    {
        try {
            $post = $this->postRepository->find($id);

            return $post;
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
            $this->messageService->sendMessageToQueue('post_created', $message);

            $this->loggerService->send('post_new', 'info', 'Post criado', $post->toArray());

            return $post;
        } catch (\Throwable $th) {

            $this->loggerService->send(
                'post_new',
                'error',
                'Erro ao enviar novo post para a fila',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao enviar novo post para a fila');
        }
    }

    public function updatePost($id, Post $post): Post
    {
        try {

            $updatedPost = $this->postRepository->update($id, $post);
        } catch (\Throwable $th) {

            $this->loggerService->send(
                'post_updt',
                'error',
                'Erro ao atualizar post no banco de dados',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao atualizar post no banco de dados');
        }

        try {
            $message = json_encode($updatedPost);

            $this->messageService->sendMessageToQueue('post_updated', $message);

            $this->loggerService->send(
                'post_updt',
                'info',
                'Post atualizado',
                $updatedPost->toArray()
            );

            return $updatedPost;
        } catch (\Throwable $th) {

            $this->loggerService->send(
                'post_updt',
                'error',
                'Erro ao enviar mensagem com post atualizado para a fila',
                [
                    'error' => $th->getMessage()
                ]
            );

            throw new \Exception('Erro ao enviar mensagem com post atualizado para a fila');
        }
    }

    public function deletePost($id): void
    {
        try {
            $this->postRepository->delete($id);
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
    }
}
