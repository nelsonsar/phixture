<?php

namespace Phixture;

class FixtureGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldBuildAFixtureWithGivenTableName()
    {
        $xmlFile = <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<dataset>
    <table name="representative">
        <column>id</column>
        <column>name</column>
        <column>phone</column>
    </table>
</dataset>
XML;

        $connection = new PDOMock;

        $connectorMock = $this->getMockBuilder('\Phixture\Database\Connector')
            ->setConstructorArgs(array($connection))
            ->getMock();


        $schemaBuilderMock = $this->getMockBuilder('\Phixture\Database\Table\SchemaDescriber')
            ->setConstructorArgs(array($connection))
            ->getMock();

        $schemaBuilderMock->expects($this->once())
            ->method('getColumnsFromTable')
            ->with('representative')
            ->will($this->returnValue(array(
                'id', 'name', 'phone'
            )));

        $connectorMock->expects($this->once())
            ->method('getSchemaDescriber')
            ->will($this->returnValue($schemaBuilderMock));

        $this->assertXmlStringEqualsXmlString($xmlFile, FixtureGenerator::generate($connectorMock, 'representative'));
    }
}

class PDOMock extends \PDO
{
    public function __construct()
    {

    }
}
