<?php

use App\Kernel\App;
use function Http\Response\send;

session_start();

chdir(__DIR__.'/..');

require_once 'vendor/autoload.php';
require_once 'config/bootstrap.php';

$modules = [];

$app = new App();

send($app->run());
