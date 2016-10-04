<?php
namespace Test;

use App\Controllers\RoomtypeController as ControllerTest;
use App\Models\Roomtype as ModelTest;

/**
 * Class UnitTest
 */
class RoomtypeTest extends \UnitTestCase
{
    /**
     * Controller Test
     */
    public function testGetListPropertyIdNotFound()
    {
        // Dispatcher Setting
        $stub = $this->getMockBuilder("\\Phalcon\\Mvc\\Dispatcher")
                     ->setMethods(["getParam"])
                     ->getMock();
        $stub->method('getParam')
             ->willReturn(0);
        $this->di->set('dispatcher', $stub, True);

        $controller = new ControllerTest();
        $result     = $controller->getListByPropertyIdAction();
        $jsonresult = json_decode($result->getContent());

        $this->assertEquals(
            'PropertyId was not found',
            $jsonresult->message,
            'Roomtype controller : Error! test'
        );
    }

    public function testGetListRoomtypesAction()
    {
        // Dispatcher Setting
        $stub = $this->getMockBuilder("\\Phalcon\\Mvc\\Dispatcher")
                     ->setMethods(["getParam"])
                     ->getMock();
        $stub->method('getParam')
             ->willReturn(1);
        $this->di->set('dispatcher', $stub, true);

        $controller = new ControllerTest();

        $roomtypes = [
            [
                'id'   => 1,
                'name' => 'aa'
            ],
            [
                'id'   => 2,
                'name' => 'bb'
            ]
        ];
        $stubModel = $this->getMockBuilder("\\App\\Models\\Roomtype")
                          ->setMethods(["selectRoomtypesByProperty"])
                          ->getMock();
        $stubModel->method('selectRoomtypesByProperty')
                  ->willReturn($roomtypes);

        // controller에 Test를 위한 Roomtype 모델에 Injection 적용
        $reflector = new \ReflectionObject($controller);
        $method    = $reflector->getMethod('setRoomTypeModel');
        $method->setAccessible(true);
        $method->invoke($controller, $stubModel);

        $result    = $controller->getListByPropertyIdAction();

        $this->assertEquals(
            $roomtypes,
            json_decode($result->getContent(), true),
            'Roomtype controller : getListByPropertyIdAction test'
        );
    }

    public function testAddPropertyIdNotFound()
    {
        // Dispatcher Setting
        $stub = $this->getMockBuilder("\\Phalcon\\Mvc\\Dispatcher")
                     ->setMethods(["getParam"])
                     ->getMock();
        $stub->method('getParam')
             ->willReturn(0);
        $this->di->set('dispatcher', $stub, True);

        $controller = new ControllerTest();
        $result     = $controller->addAction();
        $jsonresult = json_decode($result->getContent());

        $this->assertEquals(
            'PropertyId was not found',
            $jsonresult->message,
            'Roomtype controller : Error! test'
        );
    }

    public function testAddRoomtypeKeyNotFound()
    {
        // Dispatcher Setting
        $stub = $this->getMockBuilder("\\Phalcon\\Mvc\\Dispatcher")
                     ->setMethods(["getParam"])
                     ->getMock();
        $stub->method('getParam')
             ->willReturn(1);
        $this->di->set('dispatcher', $stub, True);

        // Request Json Setting
        $reqjson = '{"sample":"sample"}';
        $jsonRow = json_decode($reqjson);

        $stubjson = $this->getMockBuilder("\\Phalcon\\Mvc\\Request")
                     ->setMethods(["getJsonRawBody"])
                     ->getMock();
        $stubjson->method('getJsonRawBody')
             ->willReturn($jsonRow);
        $this->di->set('request', $stubjson, True);

        $controller = new ControllerTest();
        $result     = $controller->addAction();
        $jsonresult = json_decode($result->getContent());

        $this->assertEquals(
            'Json parameter was not \'roomtype\' key',
            $jsonresult->message,
            'Roomtype controller : Error! test'
        );
    }

    public function testAddRoomtypeNotFound()
    {
        // Dispatcher Setting
        $stub = $this->getMockBuilder("\\Phalcon\\Mvc\\Dispatcher")
                     ->setMethods(["getParam"])
                     ->getMock();
        $stub->method('getParam')
             ->willReturn(1);
        $this->di->set('dispatcher', $stub, True);

        // Request Json Setting
        $reqjson = '{"roomtype":""}';
        $jsonRow = json_decode($reqjson);

        $stubjson = $this->getMockBuilder("\\Phalcon\\Mvc\\Request")
                     ->setMethods(["getJsonRawBody"])
                     ->getMock();
        $stubjson->method('getJsonRawBody')
             ->willReturn($jsonRow);
        $this->di->set('request', $stubjson, True);

        $controller = new ControllerTest();
        $result     = $controller->addAction();
        $jsonresult = json_decode($result->getContent());

        $this->assertEquals(
            'Roomtype was not found',
            $jsonresult->message,
            'Roomtype controller : Error! test'
        );
    }

    public function testAddPropertyIsNone()
    {
        // Dispatcher Setting
        $stub = $this->getMockBuilder("\\Phalcon\\Mvc\\Dispatcher")
                     ->setMethods(["getParam"])
                     ->getMock();
        $stub->method('getParam')
             ->willReturn(1); // Property 없는 ID 값을 입력해야함
        $this->di->set('dispatcher', $stub, True);

        // Request Json Setting
        $reqjson = '{"roomtype":"none PropertyID"}';
        $jsonRow = json_decode($reqjson);

        $stubjson = $this->getMockBuilder("\\Phalcon\\Mvc\\Request")
                     ->setMethods(["getJsonRawBody"])
                     ->getMock();
        $stubjson->method('getJsonRawBody')
             ->willReturn($jsonRow);
        $this->di->set('request', $stubjson, True);

        $controller = new ControllerTest();

        $stubModel = $this->getMockBuilder("\\App\\Models\\Roomtype")
                          ->setMethods(["selectProperty"])
                          ->getMock();
        $stubModel->method('selectProperty')
                  ->willReturn([]);

        // controller에 Test를 위한 Roomtype 모델에 Injection 적용
        $reflector = new \ReflectionObject($controller);
        $method    = $reflector->getMethod('setRoomTypeModel');
        $method->setAccessible(true);
        $method->invoke($controller, $stubModel);

        $result     = $controller->addAction();
        $jsonresult = json_decode($result->getContent());

        $this->assertEquals(
            'Property is none',
            $jsonresult->message,
            'Roomtype controller : Error! test'
        );
    }

    public function testAddDupInRoomtypeByProperty()
    {
        // Dispatcher Setting
        $stub = $this->getMockBuilder("\\Phalcon\\Mvc\\Dispatcher")
                     ->setMethods(["getParam"])
                     ->getMock();
        $stub->method('getParam')
             ->willReturn(1); // Property 없는 ID 값을 입력해야함
        $this->di->set('dispatcher', $stub, True);

        // Request Json Setting
        $reqjson = '{"roomtype":"중복된방"}';
        $jsonRow = json_decode($reqjson);

        $stubjson = $this->getMockBuilder("\\Phalcon\\Mvc\\Request")
                     ->setMethods(["getJsonRawBody"])
                     ->getMock();
        $stubjson->method('getJsonRawBody')
             ->willReturn($jsonRow);
        $this->di->set('request', $stubjson, True);

        $controller = new ControllerTest();

        $stubModel = $this->getMockBuilder("\\App\\Models\\Roomtype")
                          ->setMethods(["selectRoomtypesByProperty"])
                          ->getMock();
        $stubModel->method('selectRoomtypesByProperty')
                  ->willReturn(1);

        // controller에 Test를 위한 Roomtype 모델에 Injection 적용
        $reflector = new \ReflectionObject($controller);
        $method    = $reflector->getMethod('setRoomTypeModel');
        $method->setAccessible(true);
        $method->invoke($controller, $stubModel);

        $result     = $controller->addAction();
        $jsonresult = json_decode($result->getContent());

        $this->assertEquals(
            'Roomtype Name Duplicated in property',
            $jsonresult->message,
            'Roomtype controller : Error! test'
        );
    }

    public function testAddRoomtypeInsertTrue()
    {
        // Dispatcher Setting
        $stub = $this->getMockBuilder("\\Phalcon\\Mvc\\Dispatcher")
                     ->setMethods(["getParam"])
                     ->getMock();
        $stub->method('getParam')
             ->willReturn(1);
        $this->di->set('dispatcher', $stub, True);

        // Request Json Setting
        $reqjson = '{"roomtype":"입력가능한방"}';
        $jsonRow = json_decode($reqjson);

        $stubjson = $this->getMockBuilder("\\Phalcon\\Mvc\\Request")
                     ->setMethods(["getJsonRawBody"])
                     ->getMock();
        $stubjson->method('getJsonRawBody')
             ->willReturn($jsonRow);
        $this->di->set('request', $stubjson, True);

        $controller = new ControllerTest();

        $stubModel = $this->getMockBuilder("\\App\\Models\\Roomtype")
                          ->setMethods(["insertRoomtypeByProperty"])
                          ->getMock();
        $stubModel->method('insertRoomtypeByProperty')
                  ->willReturn(1);

        // controller에 Test를 위한 Roomtype 모델에 Injection 적용
        $reflector = new \ReflectionObject($controller);
        $method    = $reflector->getMethod('setRoomTypeModel');
        $method->setAccessible(true);
        $method->invoke($controller, $stubModel);

        $result     = $controller->addAction();
        $jsonresult = json_decode($result->getContent());

        $this->assertEquals(
            'Roomtype Inserted',
            $jsonresult->message,
            'Roomtype controller : Add! test'
        );
    }

    // public function testAddRoomtypeInsertFalse()
    // {
    //     // Dispatcher Setting
    //     $stub = $this->getMockBuilder("\\Phalcon\\Mvc\\Dispatcher")
    //                  ->setMethods(["getParam"])
    //                  ->getMock();
    //     $stub->method('getParam')
    //          ->willReturn(1);
    //     $this->di->set('dispatcher', $stub, True);

    //     // Request Json Setting
    //     $reqjson = '{"roomtype":"입력가능한방"}';
    //     $jsonRow = json_decode($reqjson);

    //     $stubjson = $this->getMockBuilder("\\Phalcon\\Mvc\\Request")
    //                  ->setMethods(["getJsonRawBody"])
    //                  ->getMock();
    //     $stubjson->method('getJsonRawBody')
    //          ->willReturn($jsonRow);
    //     $this->di->set('request', $stubjson, True);

    //     $controller = new ControllerTest();

    //     $stubModel = $this->getMockBuilder("\\App\\Models\\Roomtype")
    //                       ->setMethods(["insertRoomtypeByProperty"])
    //                       ->getMock();

    //     $stubModel->method('insertRoomtypeByProperty')
    //               ->willThrowException(new \Exception("Roomtype Model Exception"));

    //     // controller에 Test를 위한 Roomtype 모델에 Injection 적용
    //     $reflector = new \ReflectionObject($controller);
    //     $method    = $reflector->getMethod('setRoomTypeModel');
    //     $method->setAccessible(true);
    //     $method->invoke($controller, $stubModel);

    //     $result     = $controller->addAction(); // Exception 처리
    // }

    /**
     * Model Test
     */
    public function testselectPropertyModel()
    {
        $mokDB = new MockTestDB();
        $stubModel = $this->getMockBuilder("\\Phalcon\\Db")
                          ->setMethods(["query"])
                          ->getMock();
        $stubModel->method('query')
                  ->willReturn($mokDB);
        $this->di->set('db', $stubModel, True);

        $model = new ModelTest();
        $property = $model->selectProperty(1);

        $this->assertCount(
            2,
            $property,
            'model! Property Count test'
        );
    }

    public function testselectRoomtypesByPropertyModel()
    {
        $mokDB = new MockTestDB();
        $stubModel = $this->getMockBuilder("\\Phalcon\\Db")
                          ->setMethods(["query"])
                          ->getMock();
        $stubModel->method('query')
                  ->willReturn($mokDB);
        $this->di->set('db', $stubModel, True);

        $model = new ModelTest();
        $roomtype = $model->selectRoomtypesByProperty(1, '테스트방1');

        $this->assertEquals(
            '테스트방1',
            $roomtype[0]['room_name'],
            'model! Roomtype Name test'
        );
    }

    public function testinsertRoomtypeByPropertyModel()
    {
        $stubModel = $this->getMockBuilder("\\Phalcon\\Db")
                          ->setMethods(["query"])
                          ->getMock();
        $stubModel->method("query")
                  // ->will($this->returnSelf());
                  ->will($this->returnCallback(function($str) { return addslashes($str); })); // SQL Query return

        $this->di->set('db', $stubModel, True);

        $model = new ModelTest();
        $roomtype = $model->insertRoomtypeByProperty(0, '테스트방1');

        $this->assertEquals(
            'INSERT INTO roomtype (property_id, name) values (:property_id, :name)',
            $roomtype,
            'model! Roomtype Insert Query test'
        );
    }
}

class MockTestDB
{
    public function fetchAll()
    {
        return [
            [
                'property_name'   => '테스트호텔',
                'room_name' => '테스트방1'
            ],
            [
                'property_name'   => '테스트호텔',
                'room_name' => '테스트방2'
            ]
        ];
    }
}
