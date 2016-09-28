<?php

namespace App\Models;

class Roomtype extends \Phalcon\Mvc\Model
{
    /**
     * Method to get the value of property
     *
     * @param string property where type
     * @param string search(type value)
     * @return sql result
     */
    public function selectProperty($type, $search)
    {
        $sql = "SELECT * FROM property where ".$type." = '".$search."'";
        return $this->getDI()->get('db')->fetchAll($sql);
    }

    /**
     * Method to get the value of roomtypes
     *
     * @param integer property_id
     * @param string search(roomtype name)
     * @return sql result
     */
    public function selectRoomtypesByProperty($property_id, $search = null)
    {
        $sql = "SELECT p.name as property_name, r.name as room_name FROM property p "
            ." inner join roomtype r on p.id = r.property_id where p.id = '".$property_id."'";

        if ($search) {
            $sql = $sql." and r.name = '".$search."'";
        }

        return $this->getDI()->get('db')->fetchAll($sql);
    }

    /**
     * Method to set the value of roomtype
     *
     * @param integer property_id
     * @param string roomtype(name)
     * @return sql result
     */
    public function insertRoomtypeByProperty($property_id, $roomtype)
    {
        $sql = "INSERT INTO roomtype (property_id, name) values ('".$property_id."', '".$roomtype."')";
        try {
            return $this->getDI()->get('db')->execute($sql);
        } catch (\Exception $e) {
            echo "Exception: ".$e->getMessage();
        }
    }
}
