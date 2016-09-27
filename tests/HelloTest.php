<?php
namespace Test;

use App\Controllers\IndexController;
use App\Models\Property;
// use App\Models\Test as ModelTest;

/**
 * Class UnitTest
 */
class HelloTest extends \UnitTestCase
{
    public function testTestCase()
    {
        $controller = new IndexController();
        $this->assertEquals(
            '<h1>Hello!</h1>',
            $controller->indexAction(),
            'hello! test'
        );
    }

    public function testPropertyModel()
    {
        $property = new Property();
        $this->assertCount(
            2,
            $property->selectAllProperties(),
            'property test'
        );
    }

    // public function testTestAction()
    // {
    //     $controller = new IndexController();
    //     $result     = $controller->testAction();
    //     $this->assertInstanceOf(
    //         \Phalcon\Http\Response::class,
    //         $result,
    //         'test! test'
    //     );
    //     $this->assertCount(
    //         2,
    //         json_decode($result->getContent(), true),
    //         'test! test'
    //     );
    // }

    // public function testModel()
    // {
    //     $model = new ModelTest();
    //     $this->assertCount(
    //         2,
    //         $model->selectAll(),
    //         'model! test' 
    //     );
    // }
}
