<?php

use App\Routes\Routes;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

Routes::loadRoutes($app);

$app->run();
