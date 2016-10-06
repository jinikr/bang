<?php

namespace App\Controllers;

use App\Models\Property;
use Phalcon\Http\Response;

class PropertyController extends ControllerBase
{

    private $m_property;

    private function setPropertyModel(Property $property)
    {
        $this->m_property = $property;
    }

    private function getPropertyModel()
    {
        if (!$this->m_property) {
            $this->m_property = new Property();
        }
        return $this->m_property;
    }

    public function indexAction()
    {
        return '<h1>Hello!</h1>';
    }

    /*
    * GET /properties
    */
    public function getAllAction()
    {
        // $property = new Property();
        $property = $this->getPropertyModel();
        return $this->response->setJsonContent($property->selectAllProperties());
    }

    /*
    * POST /properties
    */
    public function insertAction()
    {
        // $property = new Property();
        $property = $this->getPropertyModel();

        $jsonBody = $this->request->getJsonRawBody();
        $propertyName = $jsonBody->name;

        try {
            $result = $property->insertProperty($propertyName);
        } catch (Exception $e) {
                throw new Exception('Caught exception: ', $e->getMessage(), "\n");
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
