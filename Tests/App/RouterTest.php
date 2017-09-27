<?php
/**
 *
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

namespace AppTest;

use App\Kernel\Router\Router;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Route;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    public function testMatchRoute()
    {
        $this->setTestRoute();

        $array = $this->router->match('/');
        $this->assertNotEquals(0, $array);
    }

    public function testRouteNotFound()
    {
        $this->setTestRoute();

        $this->expectException(ResourceNotFoundException::class);
        $array = $this->router->match('/test');
    }

    public function testRelativeUri()
    {
        $this->setTestRoute('/test');

        $uri = $this->router->generateUri('index', [], 1);
        $this->assertEquals('/test', $uri);
    }

    public function testAbsoluteUri()
    {
        $this->setTestRoute('/test');

        $uri = $this->router->generateUri('index', [], 0);
        $this->assertEquals('http://localhost/test', $uri);
    }

    public function testMatchByName()
    {
        $this->setTestRoute('/coucou', 'bouh');

        $route = $this->router->get('bouh');
        $this->assertInstanceOf(Route::class, $route);
    }

    public function testRouteNotFoundByName()
    {
        $this->setTestRoute('/coucou', 'coucou');

        $route = $this->router->get('bouh');
        $this->assertNotInstanceOf(Route::class, $route);
    }

    private function setTestRoute(string $path = '/', string $name = 'index')
    {
        $route = new Route($path, ['_controller' => 'App:Default:index']);
        $this->router->addRoute($name, $route);
    }
}
