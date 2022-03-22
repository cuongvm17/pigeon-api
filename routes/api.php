<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->group([
    'prefix' => 'api/v1',
], function ($router) {
    $router->post('orders', 'OrderController');
});