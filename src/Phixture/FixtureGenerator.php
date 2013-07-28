<?php

namespace Phixture;

use Phixture\Database\Connector;

class FixtureGenerator
{
    public static function generate(Connector $connector, $tableName)
    {
        $columns = $connector->getSchemaDescriber()->getColumnsFromTable($tableName);

        $dom = new \DOMDocument('1.0', 'UTF-8');

        $dataSetElement = $dom->createElement('dataset');
        $tableElement = $dom->createElement('table');
        $tableElement->setAttribute('name', $tableName);
        foreach ($columns as $column) {
            $columnElement = $dom->createElement('column');
            $columnElement->nodeValue = $column;
            $tableElement->appendChild($columnElement);
        }

        $dataSetElement->appendChild($tableElement);

        $dom->appendChild($dataSetElement);

        return $dom->saveXML();
    }
}
