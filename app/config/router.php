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
        "action"     => 'getAll'
    ]
);

$router->addPost(
    '/properties',
    [
       'namespace' => 'App\Controllers',
       'controller' => 'property',
        "action"     => 'insert'
    ]
);

return $router;
