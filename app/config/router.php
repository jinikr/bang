<?php

$router = new Phalcon\Mvc\Router(false);

/*
 * NOTE: endpoint add.
 * $router->add(
 *    "/",
 *    [
 *      "namespace" => "",
 *      "controller" => "",
 *      "action"     =>  ""
 *    ]
 * );
 */

// root -> IndexController
$router->add(
    "/",
    [
      "namespace" => "App\Controllers",
      "controller" => "index",
      "action"     =>  "index"
    ]
);

// This route only will be matched if the HTTP method is GET // Roomtype List
$router->addGet(
    "/properties/{property_id}/roomtypes",
    [
      "namespace" => "App\Controllers",
      "controller" => "roomtype",
      "action"     =>  "getListByPropertyId"
    ]
);

// This route only will be matched if the HTTP method is GET // Roomtype Add
$router->addPost(
    "/properties/{property_id}/roomtypes",
    [
      "namespace" => "App\Controllers",
      "controller" => "roomtype",
      "action"     =>  "add"
    ]
);

return $router;
