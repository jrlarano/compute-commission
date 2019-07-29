#!/usr/bin/env php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Console\Controller\CommissionController;

$app = new Application();
$app -> add(new CommissionController());
$app -> run();