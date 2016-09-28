<?php
namespace App\Models;

use Phalcon\Mvc\Model;

class Property extends Model
{
    public function selectAllProperties()
    {
        $sql = "SELECT * FROM property";

        return $this->getDI()->get('db')->fetchAll($sql);
    }

    public function insertProperty($property)
    {
        $sql = "INSERT INTO property (name) VALUES ('$property->name')";

        return $this->getDI()->get('db')->execute($sql);
    }
}
