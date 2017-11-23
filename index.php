<?php

require_once "vendor/autoload.php";

$client = new \Dykyi\Client(new \GuzzleHttp\Client(), new \Dykyi\ResponseDataExtractor());
//echo $client->init();
//var_dump($client->read('foo')); die();
//$client->write('test6',['test' => 2113]);


