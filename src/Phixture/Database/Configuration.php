<?php

namespace Phixture\Database;

class Configuration
{
    private $databaseName = '';
    private $databaseHost = '';
    private $userName = '';
    private $userPassword = '';

    public function __construct(array $configuration)
    {
        if (false === $this->isInputConfigurationValid($configuration)) {
            throw new \InvalidArgumentException(
                'Invalid configuration given. Array keys must be "dbname", "host", "user", "password"'
            );
        }

        $this->databaseName = $configuration['dbname'];
        $this->databaseHost = $configuration['host'];
        $this->userName = $configuration['user'];
        $this->userPassword = $configuration['password'];
    }

    public function getDSN()
    {
        return sprintf('mysql:dbname=%s;host=%s', $this->databaseName, $this->databaseHost);
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getUserPassword()
    {
        return $this->userPassword;
    }

    private function isInputConfigurationValid(array $inputConfiguration)
    {
        $validKeys = array('dbname', 'host', 'user', 'password');

        $intersection = array_intersect_key(array_keys($inputConfiguration), $validKeys);

        return ($intersection == $validKeys);
    }
}
