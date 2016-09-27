<?php

namespace App\Controllers;

use App\Models\Property;

class PropertyController extends ControllerBase
{

    public function indexAction()
    {
        return '<h1>Hello!</h1>';
    }

    public function getPropertiesAction()
    {
        $property = new Property();
        return $this->response->setJsonContent($property->selectAllProperties());
    }
}