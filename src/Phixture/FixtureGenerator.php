<?php

namespace Phixture;

use Doctrine\DBAL\Connection;

class FixtureGenerator
{
    public static function generate(Connection $connection, $tableName)
    {
        $columns = $connection->getSchemaManager()->listTableColumns($tableName);

        $dom = new \DOMDocument('1.0', 'UTF-8');

        $dataSetElement = $dom->createElement('dataset');
        $tableElement = $dom->createElement('table');
        $tableElement->setAttribute('name', $tableName);
        foreach ($columns as $column) {
            $columnElement = $dom->createElement('column');
            $columnElement->nodeValue = $column->getName();
            $tableElement->appendChild($columnElement);
        }

        $dataSetElement->appendChild($tableElement);

        $dom->appendChild($dataSetElement);
        $dom->formatOutput = true;

        return $dom->saveXML();
    }
}
