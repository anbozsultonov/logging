<?php

require_once __DIR__. '/vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('storage/logs/your.log', Level::Info));

// add records to the log
$log->info('tests', ['tests' => 'message', 'test1' => 'ashkjasdkjas']);
