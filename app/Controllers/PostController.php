<?php

namespace App\Controllers;

use App\Models\Post;
use App\Services\PostServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostController
{
    public function __construct(
        private PostServiceInterface $service
    ) {
    }

    public function index(Request $request, Response $response, $args)
    {

        $posts = $this->service->getPosts();

        $response->getBody()->write(json_encode($posts));

        return $response->withStatus(200);
    }

    public function show(Request $request, Response $response, $args)
    {
        $post = $request->getAttribute('post');

        $body = json_encode($post);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }


    public function store(Request $request, Response $response, $args)
    {
        $data = json_decode($request->getBody()->getContents(), true);

        $post = Post::fromArray($data);

        try {
            $post = $this->service->createPost($post);

            $response->getBody()->write(json_encode([
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content
            ]));

            return $response->withStatus(201);
        } catch (\Exception $th) {
            $response
                ->getBody()
                ->write(json_encode([
                    'message' => 'Erro ao criar post',
                    'error' => $th->getMessage(),
                ]));

            return $response->withStatus(500);
        }
    }

    public function update(Request $request, Response $response, $args)
    {
        $post = $request->getAttribute('post');

        $postId = $args['id'];

        $data = $request->getParsedBody();

        $newPost = new Post(
            id: $post->id,
            title: $data['title'],
            content: $data['content'],
        );

        $updatedPost = $this->service->updatePost($postId, $newPost);

        $body = json_encode($updatedPost);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, $args)
    {
        $postId = $args['id'];

        try {
            $this->service->deletePost($postId);

            $response->getBody()->write(json_encode(['message' => 'Post deletado com sucesso']));

            return $response->withStatus(200);
        } catch (\Exception $ex) {
            $response->getBody()->write(json_encode(['message' => 'Erro ao deletar post', 'error' => $ex->getMessage()]));
            return $response->withStatus(500);
        }
    }
}
