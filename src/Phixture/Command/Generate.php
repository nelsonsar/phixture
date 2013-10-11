<?php

namespace Phixture\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Phixture\Database\ConnectorFactory;
use Phixture\FixtureGenerator;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class Generate extends Command
{
    protected function configure()
    {
        $this->setName('phixture:generate')
            ->setDescription('Generate XML fixture for given table')
            ->addArgument('database-user', InputArgument::REQUIRED, 'User that has access to database passed into database-name')
            ->addArgument('database-pass', InputArgument::REQUIRED, 'Password of the user passed into database-user')
            ->addArgument('database-host', InputArgument::REQUIRED, 'Host of database that will be used')
            ->addArgument('database-name', InputArgument::REQUIRED, 'Which database will be used to generate the fixture')
            ->addArgument('table', InputArgument::REQUIRED, 'Which table will be used to generate the fixture');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tableName = $input->getArgument('table');
        $databaseUser = $input->getArgument('database-user');
        $databasePassword = $input->getArgument('database-pass');
        $databaseHost = $input->getArgument('database-host');
        $databaseName = $input->getArgument('database-name');
        $driver = $input->getArgument('driver');

        $connectionConfiguration = new Configuration;

        $connectionConfigurationParameters = array(
            'dbname' => $databaseName,
            'host' => $databaseHost,
            'user' => $databaseUser,
            'password' => $databasePassword,
            'driver' => $driver,
        );

        $connection = DriverManager::getConnection($connectionConfigurationParameters, $connectionConfiguration);

        $text = FixtureGenerator::generate($connection, $tableName);

        $output->write($text);
    }
}
