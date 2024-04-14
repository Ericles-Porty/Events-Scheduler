<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class HomeController
{
    public static function index(Request $request, Response $response, $args)
    {
        $response->getBody()->write("<h1>API :)</h1>");
        return $response;
    }
}
