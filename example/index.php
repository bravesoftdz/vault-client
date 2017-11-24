<?php

require_once '../vendor/autoload.php';

use Dykyi\VaultClient;
use Dykyi\ResponseDataExtractor;
use GuzzleHttp\Client;

if (!file_exists(__DIR__ . '/.env')) {
    throw new \Exception(sprintf('File %s not found!', '.env'));
}
$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$client = new VaultClient(new Client(), new ResponseDataExtractor());
if ($client->init()) {
    $client->write('db', ['user' => 'password']);
    $client->read('db');

    $client->update('db', ['user' => 'new_password']);
    $client->read('db');

    $client->delete('db');
}
