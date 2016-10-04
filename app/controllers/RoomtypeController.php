<?php

namespace App\Controllers;

use App\Models\Roomtype;

class RoomtypeController extends ControllerBase
{
    /**
     * Controller Method Test에 활용 / $_roomtype / setRoomTypeModel / getRoomTypeModel
     */
    private $_roomtype;

    private function setRoomTypeModel(Roomtype $roomtype)
    {
        $this->_roomtype = $roomtype;
    }

    private function getRoomTypeModel()
    {
        if (!$this->_roomtype) {
            $this->_roomtype = new Roomtype();
        }
        return $this->_roomtype;
    }

    /**
     * Method to get the value of roomtypes
     */
    public function getListByPropertyIdAction()
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

        return $this->response->setJsonContent(
            $this->getRoomTypeModel()->selectRoomtypesByProperty($propertyId)
        );
    }

    /**
     * Method to get the value of roomtypes
     * [1] Prmam Check -> [2] Property Check -> [3] Roomtype Duplicate Check -> [4] Roomtype Insert
     */
    public function addAction()
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
        if ( !isset($jsonRow->roomtype) ) {
            return $this->response->setJsonContent(
                [
                    "status" => "Error",
                    "message" => "Json parameter was not 'roomtype' key"
                ]
            );
        }

        $roomtype = $jsonRow->roomtype;
        if (!$roomtype) {
            return $this->response->setJsonContent(
                [
                    "status" => "Error",
                    "message" => "Roomtype was not found"
                ]
            );
        }

        // Property Check
        $getRoomtype = $this->getRoomTypeModel()->selectProperty($propertyId);
        if (count($getRoomtype) == 0) {
            return $this->response->setJsonContent(
                [
                    "status" => "Error",
                    "message" => "Property is none"
                ]
            );
        }

        // Roomtype Duplicate Check
        $getRoomtype = $this->getRoomTypeModel()->selectRoomtypesByProperty($propertyId, $roomtype);
        if (count($getRoomtype) > 0) {
            return $this->response->setJsonContent(
                [
                    "status" => "Error",
                    "message" => "Roomtype Name Duplicated in property"
                ]
            );
        }

        // Roomtype Insert
        $result = $this->getRoomTypeModel()->insertRoomtypeByProperty($propertyId, $roomtype);

        if (!$result) {
            foreach ($result->getMessages() as $message) {
                return $this->response->setJsonContent(
                    [
                        "status" => "Insert Error",
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
