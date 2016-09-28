<?php

namespace App\Controllers;

use App\Models\Roomtype;

class RoomtypeController extends ControllerBase
{
    /**
     * Method index
     */
    public function indexAction()
    {
        // Todo
    }

    /**
     * Method to get the value of roomtypes
     */
    public function byroomtypesAction()
    {
        $propertyId = $this->dispatcher->getParam("property_id");
        if (!$propertyId) {
            return $this->response->setJsonContent(
                [
                    "status" => "Error",
                    "message" => "PropertyId was not found"
                ]
            );
        }

        $roomtypes = new Roomtype();
        return $this->response->setJsonContent($roomtypes->selectRoomtypesByProperty($propertyId, null));
    }

    /**
     * Method to get the value of roomtypes
     * [1] Prmam Check -> [2] Property Check -> [3] Roomtype Duplicate Check -> [4] Roomtype Insert
     */
    public function addroomtypeAction()
    {
        // Prmam Check
        $propertyId = $this->dispatcher->getParam("property_id");
        if (!$propertyId) {
            return $this->response->setJsonContent(
                [
                    "status" => "Error",
                    "message" => "PropertyId was not found"
                ]
            );
        }

        $jsonRow = $this->request->getJsonRawBody();
        $roomtype = $jsonRow->roomtype;
        if (!$roomtype) {
            return $this->response->setJsonContent(
                [
                    "status" => "Error",
                    "message" => "Roomtype was not found"
                ]
            );
        }

        $roomtypes = new Roomtype();
        // Property Check
        $getRoomtype = $roomtypes->selectProperty("id", $propertyId);
        if (count($getRoomtype) == 0) {
            return $this->response->setJsonContent(
                [
                    "status" => "Error",
                    "message" => "Property is none"
                ]
            );
        }

        // Roomtype Duplicate Check
        $getRoomtype = $roomtypes->selectRoomtypesByProperty($propertyId, $roomtype);
        if (count($getRoomtype) > 0) {
            return $this->response->setJsonContent(
                [
                    "status" => "Error",
                    "message" => "Roomtype Name Duplicated in property"
                ]
            );
        }

        // Roomtype Insert
        $result = $roomtypes->insertRoomtypeByProperty($propertyId, $roomtype);

        if (!$result) {
            foreach ($result->getMessages() as $message) {
                return $this->response->setJsonContent(
                    [
                        "status" => "OK",
                        "message" => $message->getMessage()
                    ]
                );
            }
        }

        if ($result) {
            return $this->response->setJsonContent(
                [
                    "status" => "OK",
                    "message" => "Roomtype Inserted"
                ]
            );
        }
    }
}
