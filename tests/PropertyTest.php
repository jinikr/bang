<?php
namespace Test;

use App\Controllers\PropertyController;
use App\Models\Property;
use Phalcon\Http\Client\Request;
use Phalcon\Http\Response;


/**
 * Class UnitTest
 */
class PropertyTest extends \UnitTestCase
{
    //Property Insert Test
    // public function testInsertPropertyModel()
    // {
    //     $property = new Property();
    //     $data = '{"name":"다다호텔"}';
    //     $result = $property->insertProperty(json_decode($data));
    //     $this->assertTrue($result);
    // }

    public function testSelectPropertyModel()
    {
        $property = new Property();
        $this->assertCount(
            2,
            $property->selectAllProperties(),
            'property test'
        );
    }
}
