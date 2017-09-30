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

class BaseExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('img', [$this, 'getImage']),
            new \Twig_SimpleFunction('css', [$this, 'getCSS']),
            new \Twig_SimpleFunction('url', [$this, 'getUrl']),
            new \Twig_SimpleFunction('path', [$this, 'getUrl']),
        ];
    }

    public function getImage(string $name): string
    {
        return 'Resources/Images/'.$name;
    }

    public function getCSS(string $name): string
    {
        return 'Resources/CSS/'.$name;
    }

    public function getUrl()
    {
    }
}
