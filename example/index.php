<?php

require_once '../vendor/autoload.php';

use Dykyi\VaultClient;
use Dykyi\ResponseDataExtractor;
use GuzzleHttp\Client;

$client = new VaultClient(new Client(), new ResponseDataExtractor());
$client->setOptions('your_host','your_token');

if ($client->init()) {
    $client->write('db', ['user' => 'password']);

    echo 'Create key: ';
    print_r($client->read('db'));
    echo '<br>';

    echo 'Update key: ';
    $client->update('db', ['user' => 'new_password']);
    print_r($client->read('db'));
    echo '<br>';

    echo 'Delete key: ';
    echo (int)$client->delete('db');
}
