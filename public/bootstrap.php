<?php

use App\Routes\Routes;
use Logger\Elasticsearch\ElasticsearchLogger;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$env = file_get_contents(__DIR__ . '/../.env');
$lines = explode("\n", $env);
foreach ($lines as $line) {
    // Regex key=value
    preg_match("/([^#]+)\=(.*)/", $line, $matches);
    if (isset($matches[2])) {
        putenv(trim($line));
    }
}


$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true, new ElasticsearchLogger);

Routes::loadRoutes($app);

$app->run();
