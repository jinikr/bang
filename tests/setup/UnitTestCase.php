<?php

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Test\UnitTestCase as PhalconTestCase;

abstract class UnitTestCase extends PhalconTestCase
{
    /**
     * @var \Voice\Cache
     */
    protected $_cache;

    /**
     * @var \Phalcon\Config
     */
    protected $_config;

    /**
     * @var bool
     */
    private $_loaded = false;

    public function setUp()
    {
        $this->checkExtension('phalcon');

        // Reset the DI container
        Di::reset();

        // Instantiate a new DI container
        $di = new FactoryDefault();

        $di->set('db', function () {
            return new DbAdapter([
                "host"     => "localhost",
                "username" => "db_user",
                "password" => "db_password",
                "dbname"   => "new_db"
            ]);
        });

        $this->di = $di;

        $this->_loaded = true;
    }

    /**
     * Check if the test case is setup properly
     *
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp().');
        }
    }
}
