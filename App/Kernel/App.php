<?php
/**
 *  Copyright Christophe Daloz - De Los Rios, 2017
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the “Software”), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  The Software is provided “as is”, without warranty of any kind, express or
 *  implied, including but not limited to the warranties of merchantability,
 *  fitness for a particular purpose and noninfringement. In no event shall the
 *  authors or copyright holders be liable for any claim, damages or other liability,
 *  whether in an action of contract, tort or otherwise, arising from, out of or in
 *  connection with the software or the use or other dealings in the Software.
 */

namespace App\Kernel;

use DI\ContainerBuilder;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;

class App
{
    /**
     * @var \DI\Container
     */
    private $container;

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    private $request;

    public function __construct()
    {
        global $container;

        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->addDefinitions('App/Config/injection.php');
        $container = $builder->build();
        $this->container = $container;

        $this->request = ServerRequest::fromGlobals();
    }

    /**
     * Execute controller and return a ResponseInterface
     * @return ResponseInterface
     */
    public function run()
    {
        $router = $this->container->get(RouterFactory::class)::create('App/Config/routes.json');
        $route = $router->match($this->request->getServerParams()['REDIRECT_URL']);

        $params = $route;
        unset($params['_controller'], $params['_route']);

        $array = explode(':', $route['_controller']);
        $namespace = $array[0].'\\Controller\\';
        $controller = $array[1].'Controller';
        $action = $array[2].'Action';

        $class = $namespace.$controller;
        $data = new $class($this->container);

        return call_user_func_array([$data, $action], $params);
    }
}
