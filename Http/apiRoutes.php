<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => LaravelLocalization::transRoute('contact::routes.contact')], function (Router $router) {
    $router->post('send', [
        'uses' => 'PublicController@send',
        'as'   => 'api.contact.send'
    ]);
});