<?php

require __DIR__ . '/vendor/autoload.php';

use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;
use Aura\Router\RouterContainer;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

// create a server request object
$request = ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

// create the router container and get the routing map
$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

// add a route to the map, and a handler for it
$map->get('blog.read', '/blog/{id}', function ($request) {
    $id = (int) $request->getAttribute('id');
    $response = new Response();
    $response->getBody()->write("You asked for blog entry {$id}.");
    return $response;
});

$map->get('players', '/players', function ($request) {
    $data = getServerInfo();
    $response = new Response();
    $response->getBody()->write($data->players->online);
    return $response;
});

$map->get('text', '/text', function ($request) {
    $data = getServerInfo();
    $response = new Response();
    $response->getBody()->write($data->description->text);
    return $response;
});

$map->get('test', '/test', function ($request) {
    $response = new Response();
    $response->getBody()->write("Hello World");
    return $response;
});

// get the route matcher from the container ...
$matcher = $routerContainer->getMatcher();

// .. and try to match the request to a route.
$route = $matcher->match($request);
if (! $route) {
    echo "No route found for the request.";
    exit;
}

// add route attributes to the request
foreach ($route->attributes as $key => $val) {
    $request = $request->withAttribute($key, $val);
}

// dispatch the request to the route handler.
// (consider using https://github.com/auraphp/Aura.Dispatcher
// in place of the one callable below.)
$callable = $route->handler;
$response = $callable($request);

// emit the response
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
http_response_code($response->getStatusCode());
echo $response->getBody();


function getServerInfo() {
    try
    {
        $Query = new MinecraftPing( 'planethouki.ddns.net', 25565 );
        
        // print_r( $Query->Query() );
        $data = $Query->Query();
    }
    catch( MinecraftPingException $e )
    {
        echo $e->getMessage();
    }
    finally
    {
        if( $Query )
        {
            $Query->Close();
        }
    }

    return $data;
}

?>