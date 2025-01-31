<?php 

namespace App\Routes;
use App\Controllers\GetMessagesNotifyPayment;
use Slim\App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app, $messageRepositoryRDS){
    $app->get('/', [new GetMessagesNotifyPayment($messageRepositoryRDS)]);
};