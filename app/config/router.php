<?php

$router = new Phalcon\Mvc\Router(false);

/*
 * NOTE: endpoint add.
 * $router->add('/', array(
 *    'namespace' => '',
 *    'controller' => '',
 *    "action"     => ''
 * ));
 */

// root -> IndexController
$router->add(
    '/',
    [
       'namespace' => 'App\Controllers',
       'controller' => 'index',
        "action"     => 'index'
    ]
);

$router->addGet(
    '/properties',
    [
       'namespace' => 'App\Controllers',
       'controller' => 'property',
        "action"     => 'getProperties'
    ]
);

$router->addPost(
    '/properties',
    [
       'namespace' => 'App\Controllers',
       'controller' => 'property',
        "action"     => 'postProperties'
    ]
);

return $router;
