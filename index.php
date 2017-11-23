<?php

require_once "vendor/autoload.php";

use Dykyi\Client;
use Dykyi\ResponseDataExtractor;
use GuzzleHttp\Client as GuzzClient;

$client = new Client(new GuzzClient(), new ResponseDataExtractor());
if ($client->init()){
    $client->write('db',['user' => 'password']);
    $client->read('db');

    $client->update('db',['user' => 'new_password']);
    $client->read('db');

    $client->delete('db');
}


