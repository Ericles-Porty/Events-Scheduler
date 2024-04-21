<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Event;
use App\Services\EventServiceInterface;
use App\Validators\EventValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EventController
{
    public function __construct(
        private EventServiceInterface $service,
        private EventValidator $validator
    ) {
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $events = $this->service->getEvents();

        $body = '[' . implode(',', $events) . ']';

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }

    public function show(Request $request, Response $response, array $args): Response
    {

        $eventId = $args['id'];

        $event = $this->service->getEvent($eventId);

        if (!$event) {
            return $response->withStatus(404);
        }

        $response->getBody()->write($event->toJson());

        return $response->withStatus(200);
    }


    public function store(Request $request, Response $response, array $args): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        $error = $this->validator->validateStore($data);

        if ($error) {

            $response->getBody()->write(json_encode($error->toArray()));

            return $response->withStatus($error->code);
        }

        $event = Event::fromArray($data);

        try {
            $event = $this->service->createEvent($event);

            $response->getBody()->write($event->toJson());

            return $response->withStatus(201);
        } catch (\Exception $th) {
            $response
                ->getBody()
                ->write(json_encode([
                    'message' => 'Erro ao criar evento',
                    'error' => $th->getMessage(),
                ]));

            return $response->withStatus(500);
        }
    }
}
