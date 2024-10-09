<?php

// get current uri path
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = require('routes.php');

// handle existing routes or abort
function routeToController($uri, $routes)
{
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}

// handle errors
function abort($code = 404)
{
    // get current page code
    http_response_code($code);

    // return relevant error page
    require "views/" . $code . ".php";

    die();
}

routeToController($uri, $routes);
