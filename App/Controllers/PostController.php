<?php

namespace App\Controllers;

use App\Models\Post;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostController
{

    public function index(Request $request, Response $response, $args)
    {
        $posts = Post::getAll();

        $response->getBody()->write(json_encode($posts));

        return  $response;
    }

    public function show(Request $request, Response $response, $args)
    {
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        $postId = $args['id'];

        try {

            $post = Post::getOne($postId);

            if (!$post) {

                $response->getBody()->write(json_encode(['message' => 'Post não encontrado']));

                return $response->withStatus(404);
            }

            $response->getBody()->write(json_encode(['id' => $post->id, 'title' => $post->title, 'content' => $post->content]));

            return $response;
        } catch (\Throwable $th) {

            $response->getBody()->write(json_encode(['message' => 'Erro ao buscar post', 'error' => $th->getMessage]));

            return $response->withStatus(500);
        }
    }


    public function store(Request $request, Response $response, $args)
    {
        $data = json_decode($request->getBody()->getContents(), true);

        $post = new Post();

        $post->title = $data['title'];
        $post->content = $data['content'];

        try {
            $post = Post::create($post);

            $response->getBody()->write(json_encode(['id' => $post->id, 'title' => $post->title, 'content' => $post->content]));

            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write(json_encode(['message' => 'Erro ao criar post', 'error' => $th->getMessage]));

            return $response->withStatus(500);
        }
    }

    public function update(Request $request, Response $response, $args)
    {
        $postId = $args['id'];

        $data = json_decode($request->getBody()->getContents(), true);

        $post = Post::getOne($postId);

        $post->title = $data['title'];
        $post->content = $data['content'];

        $updatedPost = Post::update($post);

        $response->getBody()->write(json_encode(['id' => $updatedPost->id, 'title' => $updatedPost->title, 'content' => $updatedPost->content]));

        return $response;
    }

    public function delete(Request $request, Response $response, $args)
    {
        $postId = $args['id'];

        try {
            Post::delete($postId);

            $response->getBody()->write(json_encode(['message' => 'Post deletado com sucesso']));

            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write(json_encode(['message' => 'Erro ao deletar post', 'error' => $th->getMessage]));

            return $response->withStatus(500);
        }
    }
}
