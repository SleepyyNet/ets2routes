<?php

use App\Entity\Modules;
use App\Kernel\Lang\LangManager;
use App\Kernel\SuperGlobals\SuperGlobals;

use function DI\object;

require_once 'config/bootstrap.php';

global $entityManager;

$json = json_decode(file_get_contents('App/Config/parameters.json'), true);
$modules = [];

$base = [
    'parameters' => $json,
    'database' => $json['database'],
    SuperGlobals::class => object(),
    LangManager::class => object()->constructor($json['lang']),
];

$repos = $entityManager->getRepository(Modules::class);
$results = $repos->findAll();

foreach ($results as $result) {
    $modules[$result->getName()] = object($result->getClassName());
}

return array_merge($base, $modules);
