<?php
namespace Test;

use App\Controllers\RoomtypeController as ControllerTest;
use App\Models\Roomtype as ModelTest;

/**
 * Class UnitTest
 */
class RoomtypeTest extends \UnitTestCase
{
    // Controller Test
    public function testbyroomtypesController()
    {
        // Get Param Setting

        $controller = new ControllerTest();
        $result = $controller->byroomtypesAction();
        $jsonresult = json_decode($result->getContent());

        $this->assertEquals(
            'PropertyId was not found',
            $jsonresult->message,
            'controller Error! test'
        );
    }

    public function testaddroomtypeController()
    {
        // Get/Post Param Setting

        $controller = new ControllerTest();
        $result = $controller->addroomtypeAction();
        $jsonresult = json_decode($result->getContent());

        $this->assertEquals(
            'PropertyId was not found',
            $jsonresult->message,
            'controller Error! test'
        );
    }

    // Model Test (Property 개수 확인 -> Roomtype Insert -> Roomtype 개수 확인)
    public function testselectPropertyModel()
    {
        $model = new ModelTest();
        $property = $model->selectProperty('id', 1);

        if (count($property) > 0)
        {
            $this->assertArrayHasKey(
                'name'
                , $property[0]
            );
        }

        $this->assertCount(
            count($property),
            $property,
            'model! test'
        );
    }

    public function testinsertRoomtypeByPropertyModel()
    {
        $model = new ModelTest();
        $this->assertTrue($model->insertRoomtypeByProperty(0, '테스트룸')); // property_id(0), roomtype_name('테스트룸')
    }

    public function testselectRoomtypesByPropertyModel()
    {
        $model = new ModelTest();
        $roomtype = $model->selectRoomtypesByProperty(1, null);
        $this->assertCount(
            count($roomtype),
            $roomtype,
            'model! test'
        );
    }
}
