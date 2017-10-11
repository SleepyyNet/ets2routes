<?php

use App\Kernel\Lang\LangManager;
use App\Kernel\QBuilder\EntityManager;
use App\Kernel\SuperGlobals\SuperGlobals;

use function DI\get;
use function DI\object;

$json = json_decode(file_get_contents('App/Config/parameters.json'), true);

return [
    \PDO::class => \DI\object()->constructor(
        'mysql:dbname='.$json['database']['dbname'].';host='.
            $json['database']['host'].';port='.$json['database']['port'],
        $json['database']['user'],
        $json['database']['password'],
        []
    ),
    SuperGlobals::class => object(),
    EntityManager::class => object()->constructor(get(\PDO::class)),
    LangManager::class => object()->constructor($json['lang']),
];
