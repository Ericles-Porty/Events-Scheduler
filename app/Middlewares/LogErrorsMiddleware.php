<?php

declare(strict_types=1);

namespace App\Middlewares;

use Logger\Elasticsearch\ElasticsearchLogger;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

class LogErrorsMiddleware
{

    public function __construct(
        private ElasticsearchLogger $logger
    ) {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        if ($response->getStatusCode() >= 400) {
            $error = [
                'status_code' => $response->getStatusCode(),
                'reason' => $response->getReasonPhrase(),
                'body' => (string) $response->getBody(),
            ];

            $this->logger->log(
                'Request Error',
                'Error on request',
                $error
            );
        }

        return $response;
    }
}
