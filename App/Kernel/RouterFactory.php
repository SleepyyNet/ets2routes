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

use App\Kernel\Router\Router;
use Symfony\Component\Routing\Route;

/**
 * Create an instance of router engine
 * @package App\Kernel
 */
class RouterFactory
{
    /**
     * Create an instance of Router
     * @param string $routeFileConf
     * @return Router
     */
    public static function create(string $routeFileConf)
    {
        $router = new Router();
        $json = json_decode(file_get_contents($routeFileConf), true);


        foreach ($json as $name => $data) {
            $path = $data['path'];
            $requirements = [];
            $defaults['_controller'] = $data['controller'];

            if (isset($data['arguments'])) {
                foreach ($data['arguments'] as $key => $value) {
                    $requirements[$key] = $value;
                }
            }

            if (isset($data['defaults'])) {
                foreach ($data['defaults'] as $key => $value) {
                    $defaults[$key] = $value;
                }
            }

            $router->addRoute($name, new Route($path, $defaults, $requirements));
        }

        return $router;
    }
}
