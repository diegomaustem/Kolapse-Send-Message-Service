<?php

use App\Controllers\GetMessagesNotifyPayment;
use App\Repositories\MessagesRepositoryInterface;
use App\Repositories\MessagesRepositoryRDS;
use Config\ConnectionRDS;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Predis\Client;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$connectionRDS        = new ConnectionRDS(new Client());
$messageRepositoryRDS = new MessagesRepositoryRDS($connectionRDS);

(require __DIR__ . '/../src/Routes/routes.php')($app, $messageRepositoryRDS);

$app->run();