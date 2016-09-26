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
$router->add('/', array(
   'namespace' => 'App\Controllers',
   'controller' => 'index',
   "action"     => 'index'
));

return $router;
