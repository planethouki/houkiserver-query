<?php

require __DIR__ . '/vendor/autoload.php';

use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;
use Aura\Router\RouterContainer;

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

$map->get('players', '/players', function ($request, $response) {
    $data = getServerInfo();
    $response->getBody()->write($data->players->online);
    return $response;
});

$map->get('text', '/text', function ($request, $response) {
    $data = getServerInfo();
    $response->getBody()->write($data->description->text);
    return $response;
});

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