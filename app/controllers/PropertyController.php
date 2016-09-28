<?php

namespace App\Controllers;

use App\Models\Property;
use Phalcon\Http\Response;

class PropertyController extends ControllerBase
{

    public function indexAction()
    {
        return '<h1>Hello!</h1>';
    }

    /*
    * GET /properties
    */
    public function getPropertiesAction()
    {
        $property = new Property();
        return $this->response->setJsonContent($property->selectAllProperties());
    }

    /*
    * POST /properties
    */
    public function postPropertiesAction()
    {
        $property = new Property();

        try {
            $result = $property->insertProperty($this->request->getJsonRawBody());
        } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        $response = new Response();

        if ($result) {
            $response->setStatusCode(201, "Created");
            $response->setJsonContent(
                [
                    "status" => "OK",
                    "data"   => "Property Insert Success!!",
                ]
            );
            return $response;
        }

        $response->setStatusCode(409, "Conflict");
        $response->setJsonContent(
            [
                "status" => "ERROR",
                "data"   => "Property Insert Fail!!",
            ]
        );

        return $response;
    }
}
