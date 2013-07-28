<?php

namespace Phixture\Database;

use Phixture\Database\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateANewInstanceOfConfigurationWithAnArray()
    {
        $config = array(
            'dbname' => 'testdb',
            'host' => 'localhost',
            'user' => 'test',
            'password' => 'test',
        );

        $configuration = new Configuration($config);

        $this->assertInstanceOf('Phixture\Database\Configuration', $configuration);
    }

    /**
    * @expectedException \InvalidArgumentException
    */
    public function testShouldThrowAnExceptionWhenConfigurationArrayIsInvalid()
    {
        $config = array(
            'database' => 'testdb',
            'host' => 'localhost',
            'user' => 'test',
            'password' => 'test',
        );

        $configuration = new Configuration($config);
    }

    public function testShouldReturnDSNBasedInDatabaseNameAndHost()
    {
        $expectedResult = 'mysql:dbname=testdb;host=localhost';

        $config = array(
            'dbname' => 'testdb',
            'host' => 'localhost',
            'user' => 'test',
            'password' => 'test',
        );

        $configuration = new Configuration($config);

        $this->assertSame($expectedResult, $configuration->getDSN());
    }

    public function testShouldReturnUserName()
    {
        $expectedResult = 'test';

        $config = array(
            'dbname' => 'testdb',
            'host' => 'localhost',
            'user' => 'test',
            'password' => 'test',
        );

        $configuration = new Configuration($config);

        $this->assertSame($expectedResult, $configuration->getUserName());
    }

    public function testShouldReturnUserPassword()
    {
        $expectedResult = 'test';

        $config = array(
            'dbname' => 'testdb',
            'host' => 'localhost',
            'user' => 'test',
            'password' => 'test',
        );

        $configuration = new Configuration($config);

        $this->assertSame($expectedResult, $configuration->getUserPassword());
    }
}
