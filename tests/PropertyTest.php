<?php
namespace Test;

use App\Controllers\PropertyController;
use App\Models\Property;


/**
 * Class UnitTest
 */
class PropertyTest extends \UnitTestCase
{
    public function testSelectPropertyModel()
    {
        $property = new Property();
        $this->assertCount(
            2,
            $property->selectAllProperties(),
            'property test'
        );
    }

    public function testInsertControllerTest()
    {
        $request = '{"name":"호텔"}';
        $requestJson = json_decode($request);

        $stub = $this->getMockBuilder("\\Phalcon\\Mvc\\Request")
                          ->setMethods(['getJsonRawBody'])
                          ->getMock();
        $stub->method('getJsonRawBody')
                  ->willReturn($requestJson);
        $this->di->set('request', $stub, True);

        $controller = new PropertyController();

        $stubModel = $this->getMockBuilder("\\App\\Models\\Property")
                          ->setMethods(['insertProperty'])
                          ->getMock();
        $stubModel->method('insertProperty')
                  ->willReturn(1);

        $reflector = new \ReflectionObject($controller);
        $method    = $reflector->getMethod('setPropertyModel');
        $method->setAccessible(true);
        $method->invoke($controller, $stubModel);

        $result     = $controller->insertAction();

        $jsonresult = json_decode($result->getContent());

        $this->assertEquals(
            'OK',
            $jsonresult->status,
            'insertAction test'
        );
    }
}
