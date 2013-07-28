<?php

namespace Phixture\Database;

class ConnectorTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateANewInstanceOfSchemaDescriber()
    {
        $connector = new Connector(new PDOMock);

        $this->assertInstanceOf('\Phixture\Database\Table\SchemaDescriber', $connector->getSchemaDescriber());
    }
}

class PDOMock extends \PDO
{
    public function __construct()
    {

    }
}
