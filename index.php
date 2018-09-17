<?php

require __DIR__ . '/vendor/autoload.php';

use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

try
{
    $Query = new MinecraftPing( 'planethouki.ddns.net', 25565 );
    
    // print_r( $Query->Query() );
    $data = $Query->Query();
    $json = json_encode($data);
    header('HTTP', true, 200);
    header('Content-Type: application/json');
    echo $json;
}
catch( MinecraftPingException $e )
{
    $json = json_encode(array(
        "message" => $e->getMessage()
    ));
    header('HTTP', true, 500);
    header('Content-Type: application/json');
    echo $json;
}
finally
{
    if( $Query )
    {
        $Query->Close();
    }
}

?>

