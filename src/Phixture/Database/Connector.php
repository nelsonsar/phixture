<?php

namespace Phixture\Database;

use Phixture\Database\Table\SchemaDescriber;

class Connector
{
    private $connection = null;
    private $schemaDescriber = null;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getSchemaDescriber()
    {
        if (null === $this->schemaDescriber) {
            $this->schemaDescriber = new SchemaDescriber($this->connection);
        }

        return $this->schemaDescriber;
    }
}
