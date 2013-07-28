<?php

namespace Phixture\Database;

class ConnectorFactory
{
    public static function getConnector(Configuration $configuration)
    {
        $dsn = $configuration->getDSN();
        $userName = $configuration->getUserName();
        $userPassword = $configuration->getUserPassword();
        $connection = new \PDO($dsn, $userName, $userPassword);
        return new Connector($connection);
    }
}
