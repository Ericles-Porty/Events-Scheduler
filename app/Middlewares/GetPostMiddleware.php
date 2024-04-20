<?php

namespace App\Middlewares;

use App\Services\PostServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

class GetPostMiddleware
{
    public function __construct(
        private PostServiceInterface $service
    ) {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $context = RouteContext::fromRequest($request);

        $route = $context->getRoute();

        $id = $route->getArgument('id');

        $post = $this->service->getPostById($id);

        if (!$post) {

            throw new HttpNotFoundException($request, message: 'Post não encontrado');
        }

        $request = $request->withAttribute('post', $post);

        return $handler->handle($request);
    }
}
