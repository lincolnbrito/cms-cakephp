<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'ContactManager',
    ['path' => '/contact-manager'],
    function (RouteBuilder $routes) {
        $routes->get('/contacts', ['controller' => 'Contacts', 'action'=>'index']);
        $routes->get('/contacts/:id', ['controller' => 'Contacts', 'action' => 'view']);
        $routes->put('/contacts/:id', ['controller' => 'Contacts', 'action' => 'update']);
        $routes->fallbacks(DashedRoute::class);
    }
);
