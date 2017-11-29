<?php

use App\Kernel\Lang\LangManager;
use App\Kernel\QBuilder\EntityManager;
use App\Kernel\QBuilder\QBuilder;
use App\Kernel\QBuilder\SelectInterface;
use App\Kernel\SuperGlobals\SuperGlobals;

use function DI\get;
use function DI\object;
use Modules\News\Controller\NewsController;

$json = json_decode(file_get_contents('App/Config/parameters.json'), true);
$modules = [];
$pdo = new \PDO(
    'mysql:dbname='.$json['database']['dbname'].';host='.
    $json['database']['host'].';port='.$json['database']['port'],
    $json['database']['user'],
    $json['database']['password']
);

$base = [
    'parameters' => $json,
    'database' => $json['database'],
    \PDO::class => object()->constructor(
        'mysql:dbname='.$json['database']['dbname'].';host='.
            $json['database']['host'].';port='.$json['database']['port'],
        $json['database']['user'],
        $json['database']['password'],
        []
    ),
    QBuilder::class => object()->constructor(get(\PDO::class)),
    SuperGlobals::class => object(),
    //EntityManager::class => object()->constructor(get(\PDO::class)),
    LangManager::class => object()->constructor($json['lang']),
];

$builder = new QBuilder($pdo);
$select = $builder->select('modules');
$select
    ->addField('id')
    ->addField('autolaunch')
    ->addField('state')
    ->addField('name')
    ->addField('classname')
    ->addField('author')
    ->addField('version')
    ->addWhere('state', 1);
$select->execute();
$results = $select->fetchAll();

foreach ($results as $result) {
    $modules[$result['name']] = object($result['classname']);
}

return array_merge($base, $modules);
