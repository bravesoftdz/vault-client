# Vault Server

How to run vault server on the Docker read [here](https://github.com/neb0t/docker_vault). Author: [neb0t](https://github.com/neb0t) 

# Vault Client

Vault is a tool for securely accessing secrets. A secret is anything that you want to tightly control access to, such as API keys, passwords, certificates, and more. Vault provides a unified interface to any secret, while providing tight access control and recording a detailed audit log.

## Documentation

All documentation is available on the [Vault website](https://www.vaultproject.io).

## Installation

### Composer

The preferred way to install this extension is through [Composer](http://getcomposer.org/).

Either run

```
composer require dykyi-roman/vault-client "dev-master"
```

or add

```
"dykyi-roman/vault-client": "master"
```

to the require section of your ```composer.json```

## Usage

Make sure to update your /.env file with your app ID & secret.
```
VAULT_ROOT_TOKEN_ID=5HNcw7sdf1CcafOFflUes6VOdjPaIJJEDs
VAULT_HOST=http://your-website.com/
```

## Example
```
require_once '../vendor/autoload.php';

use Dykyi\VaultClient;
use Dykyi\ResponseDataExtractor;
use GuzzleHttp\Client;

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
```
## Available environment

- DEV - ```/v1/secret/dev/```
- PROD - ```/v1/secret/prod/```
- TEST - ```/v1/secret/test/```

## Author
[Dykyi Roman](https://www.linkedin.com/in/roman-dykyi-43428543/), e-mail: [mr.dukuy@gmail.com](mailto:mr.dukuy@gmail.com)

