<?php

use App\Kernel\App;
use function Http\Response\send;

chdir(__DIR__.'/..');

require_once 'vendor/autoload.php';

$app = new App();

send( $app->run() );