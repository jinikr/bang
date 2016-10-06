<?php
namespace App\Models;

use Phalcon\Mvc\Model;

class Property extends Model
{
    public function selectAllProperties()
    {
        $pdo = $this->getDI()->get('db');

        $sql = "SELECT * FROM property";
        $query = $pdo->query($sql);

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertProperty($propertyName)
    {
        $pdo = $this->getDI()->get('db');

        $sql = $pdo->prepare("INSERT INTO property (name) VALUES (:propertyName)");
        $sql->bindParam(':propertyName', $propertyName);

        return $sql->execute();
    }
}
