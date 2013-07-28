<?php

namespace Phixture\Database\Table;

class SchemaDescriberTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldReturnColumnsNameFromGivenTable()
    {
        $expectedResult = array(
            'column_1',
            'column_2',
            'column_3'
        );

        $tableName = 'test';

        $statementMock = $this->getMock('\PDOStatement');
        $statementMock->expects($this->once())->method('execute')->will($this->returnValue(true));

        $statementMock->expects($this->once())
            ->method('fetchAll')
            ->will($this->returnValue(
                array(
                    array('Field' => 'column_1'),
                    array('Field' => 'column_2'),
                    array('Field' => 'column_3')
                )
            )
        );

        $connectionMock = $this->getMock('\Phixture\Database\Table\PDOMock');
        $connectionMock->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($statementMock));

        $schemaDescriber = new SchemaDescriber($connectionMock);

        $result = $schemaDescriber->getColumnsFromTable($tableName);

        $this->assertEquals($expectedResult, $result);
    }
}

class PDOMock extends \PDO
{
    public function __construct()
    {

    }
}
