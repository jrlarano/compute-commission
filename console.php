#!/usr/bin/env php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Console\ComputeCommissionCommand;

$app = new Application();
$app -> add(new ComputeCommissionCommand());
$app -> run();