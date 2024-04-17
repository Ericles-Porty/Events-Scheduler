<?php

use App\Handlers\AppErrorHandler;
use App\Routes\Routes;
use Elastic\Elasticsearch\Response\Elasticsearch;
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
// $container = new DI\Container();

// $container->set('logger', function () {
//     return new ElasticsearchLogger();
// });

$app = AppFactory::create();

// $app->add(new ErrorHandlerMiddleware($container->get('logger')));

Routes::loadRoutes($app);
$app->run();
