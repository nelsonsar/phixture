<?php

namespace Phixture\Database\Table;

class SchemaDescriber
{
    private $connection = null;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getColumnsFromTable($tableName)
    {
        $query = sprintf('SHOW COLUMNS FROM %s;', $tableName);

        $statement = $this->connection->prepare($query);

        if (false !== $statement->execute()) {
            $resultSet = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return array_map(
                function($columnInformation) {
                    return $columnInformation['Field'];
                }, $resultSet
            );
        }
    }
}
