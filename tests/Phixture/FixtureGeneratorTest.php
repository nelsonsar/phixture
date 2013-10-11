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

        $connectionParameters = array(
            'dbname' => 'representative',
            'host' => 'localhost',
            'user' => 'test',
            'password' => 'test',
            'driver' => 'pdo_mysql',
        );

        $connectionMock = $this->getMockBuilder('\Doctrine\DBAL\Connection')
            ->setConstructorArgs(array($connectionParameters, new \Doctrine\DBAL\Driver\PDOMySql\Driver))
            ->getMock();

        $schemaManagerMock = $this->getMockBuilder('\Doctrine\DBAL\Schema\MySqlSchemaManager')
            ->setConstructorArgs(array($connectionMock))
            ->getMock();

        $schemaManagerMock->expects($this->once())
            ->method('listTableColumns')
            ->with('representative')
            ->will($this->returnValue(
                array(
                    new \Doctrine\DBAL\Schema\Column('id', \Doctrine\DBAL\Types\Type::getType('integer')),
                    new \Doctrine\DBAL\Schema\Column('name', \Doctrine\DBAL\Types\Type::getType('string')),
                    new \Doctrine\DBAL\Schema\Column('phone', \Doctrine\DBAL\Types\Type::getType('string')),
                )
            ));

        $connectionMock->expects($this->once())
            ->method('getSchemaManager')
            ->will($this->returnValue($schemaManagerMock));

        $this->assertXmlStringEqualsXmlString($xmlFile, FixtureGenerator::generate($connectionMock, 'representative'));
    }
}
