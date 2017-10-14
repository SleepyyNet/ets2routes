<?php
/**
 *  Copyright Christophe Daloz - De Los RIos, 2017
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

use App\Kernel\Lang\LangManager;
use App\Kernel\QBuilder\EntityManager;
use App\Kernel\Renderer\TwigRenderer;
use App\Kernel\Router\Router;
use DI\Container;
use GuzzleHttp\Psr7\Response;

class Controller
{
    /**
     * @var TwigRenderer
     */
    protected $renderer;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var LangManager
     */
    protected $translation;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var array
     */
    protected $parameters;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->entityManager = $container->get(EntityManager::class);

        $this->translation = $container->get(LangManager::class);
        $this->router = $container->get(RouterFactory::class)::create('App/Config/routes.json');

        $this->renderer = new TwigRenderer($this->container);
        $this->renderer->addPath('App/Views', 'App');
        
        $this->getExtensions('App/Config/twigext.json');
        $this->parameters = $container->get('parameters');
    }

    /**
     * Redirect to selected route with statusCode
     * @param string $routeName
     * @param array $parameters
     * @param int $statusCode
     * @return Response
     */
    public function redirectToRoute(string $routeName, array $parameters = [], int $statusCode = 200)
    {
        return new Response($statusCode, ['location' => $this->router->generateUri($routeName, $parameters)]);
    }

    /**
     * Redirect to URI with statusCode
     * @param string $uri
     * @param int $statusCode
     * @return Response
     */
    public function redirect(string $uri, int $statusCode = 200)
    {
        return new Response($statusCode, ['location' => $uri]);
    }

    /**
     * Generate code
     * @param int $length
     * @return string
     */
    public function generateCode(int $length)
    {
        return bin2hex(random_bytes(($length/2)));
    }

    /**
     * Get renderer extensions
     * @param string $jsonFile
     */
    protected function getExtensions(string $jsonFile): void
    {
        $json = json_decode(file_get_contents($jsonFile), true);

        foreach ($json['extensions'] as $name => $extension) {
            $this->renderer->addExtension($extension);
        }
    }
}
