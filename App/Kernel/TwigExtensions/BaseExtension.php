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

namespace App\Kernel\TwigExtensions;

use App\Kernel\RouterFactory;
use App\Kernel\SuperGlobals\SuperGlobals;
use DI\Container;

class BaseExtension extends \Twig_Extension
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var SuperGlobals
     */
    private $globals;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->globals = $this->container->get(SuperGlobals::class);
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('img', [$this, 'getImage']),
            new \Twig_SimpleFunction('css', [$this, 'getCSS']),
            new \Twig_SimpleFunction('url', [$this, 'getUrl']),
            new \Twig_SimpleFunction('path', [$this, 'getUrl']),
            new \Twig_SimpleFunction('flash', [$this, 'getFlashMessage'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('flashType', [$this, 'getFlashType']),
            new \Twig_SimpleFunction('session', [$this, 'getSession']),
        ];
    }

    public function getImage(string $name): string
    {
        return '/Resources/Images/'.$name;
    }

    public function getCSS(string $name): string
    {
        return '/Resources/CSS/'.$name;
    }

    public function getUrl(string $routeName, array $parameters = [])
    {
        $router = $this->container->get(RouterFactory::class)::create('App/Config/routes.json');
        return $router->generateUri($routeName, $parameters);
    }

    public function getFlashMessage(): string
    {
        return $this->globals->session()->getFlashMessage();
    }

    public function getFlashType(): string
    {
        return $this->globals->session()->getTypeFlashMessage();
    }

    public function getSession(string $key)
    {
        return $this->globals->session()->get($key);
    }
}
