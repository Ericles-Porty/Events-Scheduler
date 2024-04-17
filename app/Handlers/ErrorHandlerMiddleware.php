<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;

class ErrorHandlerMiddleware
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        try {
            // Chama o próximo middleware na cadeia
            $response = $next($request, $response);
        } catch (Throwable $e) {
            // Loga o erro usando o logger Elasticsearch
            $this->logger->error($e->getMessage(), [
                'exception' => $e
            ]);

            // Pode enviar uma resposta de erro personalizada, se necessário
            $response = $response->withStatus(500)->withJson([
                'error' => 'Internal Server Error'
            ]);
        }

        return $response;
    }
}
