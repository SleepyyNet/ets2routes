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

namespace App\Kernel\Router;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class Router
 * @package App\Kernel\Router
 * @author Christophe Daloz - De Los Rios <christophedlr@gmail.com>
 * @version 1.0
 */
class Router
{
    private $routes;
    private $context;
    private $urlGenerator;

    public function __construct()
    {
        $host = ( isset($_SERVER['HTTP_HOST']) ) ? $_SERVER['HTTP_HOST'] : 'localhost/ets2routes';
        $scheme = ( !empty($_SERVER['HTTPS']) ) ? 'https' : 'http';
        $queryString = ( isset($_SERVER['QUERY_STRING']) ) ?: '';

        $this->routes = new RouteCollection();
        $this->context = new RequestContext(
            '',
            'GET',
            $host,
            $scheme,
            80,
            443,
            $_SERVER['PATH'],
            $queryString
        );
        $this->urlGenerator = new UrlGenerator($this->routes, $this->context);
    }

    /**
     * Search data of route indicate by path
     * @param string $path
     * @return array
     */
    public function match(string $path): array
    {
        $matcher = new UrlMatcher($this->routes, $this->context);

        return $matcher->match($path);
    }

    /**
     * Get route by name
     * @param string $name
     * @return null|Route
     */
    public function get(string $name)
    {
        return $this->routes->get($name);
    }

    /**
     * Add new route
     * @param string $routeName
     * @param Route $route
     */
    public function addRoute(string $routeName, Route $route): void
    {
        $this->routes->add($routeName, $route);
    }

    /**
     * Generate a URL
     * @param string $routeName Name of route
     * @param array $parameters List of parameters for route
     * @param int $type 0 for absolute, 1 for relative
     * @return string
     */
    public function generateUri(string $routeName, array $parameters = [], int $type = 0): string
    {
        $path = $this->urlGenerator->generate($routeName, $parameters, $type);

        if ( substr($path, -1) === '/' ) {
            return substr($path, 0, -1);
        }

        return $path;
    }
}
