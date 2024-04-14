<?php

namespace App\Routes;

use Slim\App;

use App\Controllers\HomeController;
use App\Controllers\PostController;
use Slim\Routing\RouteCollectorProxy;

class Routes
{
    public static function loadRoutes(App $app)
    {
        $app->group('/api', function (RouteCollectorProxy $group) {
            $group->get('[/]', [HomeController::class, 'index']);
            $group->group('/posts', function (RouteCollectorProxy $group) {
                $group->get('[/]', [PostController::class, 'index']);
                $group->get('/{id}', [PostController::class, 'show']);
                $group->post('[/]', [PostController::class, 'store']);
                $group->put('/{id}', [PostController::class, 'update']);
                $group->delete('/{id}', [PostController::class, 'delete']);
            });
        });
    }
}
