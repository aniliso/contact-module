<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => LaravelLocalization::transRoute('contact::routes.contact')], function (Router $router) {
    $router->get('/', [
        'uses' => 'PublicController@index',
        'as'   => 'contact'
    ]);
    $router->post('/call', [
        'uses' => 'PublicController@send',
        'as' => 'contact.send'
    ]);
});