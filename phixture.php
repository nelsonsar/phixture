#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Phixture\Command\Generate;
use Symfony\Component\Console\Application;

$application = new Application;
$application->add(new Generate);
$application->run();
