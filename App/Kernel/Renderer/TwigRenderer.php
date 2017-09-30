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

namespace App\Kernel\Renderer;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TwigRenderer
 * @package App\Kernel\Renderer
 */
class TwigRenderer implements RendererInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var \Twig_Loader_Filesystem
     */
    private $loader;

    public function __construct()
    {
        $this->loader = new \Twig_Loader_Filesystem();
        $this->twig = new \Twig_Environment($this->loader);
    }

    /**
     * Add new path access
     * @param string $directory
     * @param string $accessName
     */
    public function addPath(string $directory, string $accessName = '__main__'): void
    {
        $this->loader->addPath($directory, $accessName);
    }

    /**
     * Add new extension
     * @param string $extensionClass
     */
    public function addExtension(string $extensionClass): void
    {
        $this->twig->addExtension(new $extensionClass());
    }

    /**
     * Add new filter
     * @param string $filterClass
     */
    public function addFilter(string $filterClass): void
    {
        $this->twig->addFilter(new $filterClass());
    }

    /**
     * Add new function
     * @param string $functionClass
     */
    public function addFunction(string $functionClass): void
    {
        $this->twig->addFunction(new $functionClass());
    }

    /**
     * Add global var
     * @param string $name
     * @param $value
     */
    public function addGlobal(string $name, $value): void
    {
        $this->twig->addGlobal($name, $value);
    }

    /**
     * Parse and return template
     * @param string $name
     * @param array $context
     * @param int $statusCode
     * @param bool $string
     * @return ResponseInterface|string
     */
    public function render(
        string $name,
        array $context = [],
        int $statusCode = 200,
        bool $string = false
    ) {
        $render = $this->twig->render($name, $context);

        if ($string) {
            return $render;
        }

        return new Response($statusCode, [], $render);
    }
}
