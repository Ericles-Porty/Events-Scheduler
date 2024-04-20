<?php

namespace App\Routes;

use Slim\App;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Middlewares\GetPostMiddleware;
use Slim\Routing\RouteCollectorProxy;

class Routes
{
    public static function loadRoutes(App $app)
    {
        $app->get('[/]', [HomeController::class, 'index']);
        $app->group('/api', function (RouteCollectorProxy $group) {
            $group->get('[/]', [HomeController::class, 'index']);
            $group->group('/posts', function (RouteCollectorProxy $group) {
                $group->get('[/]', [PostController::class, 'index']);
                $group->post('[/]', [PostController::class, 'store']);
                $group->group('/{id:[0-9]+}', function (RouteCollectorProxy $group) {
                    $group->get('[/]', [PostController::class, 'show']);
                    $group->put('[/]', [PostController::class, 'update']);
                    $group->delete('[/]', [PostController::class, 'delete']);
                })->add(GetPostMiddleware::class);
            });
        });
    }
}
