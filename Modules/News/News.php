<?php

namespace Modules\News;

use Modules\News\Controller\NewsController;

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

/**
 * Class News
 * @package Modules\News
 * @author Christophe Daloz - De Los Rios <christophedlr@gmail.com>
 * @version 1.0
 */
class News
{
    /**
     * Return classname of controller
     * @param string $name
     * @return string
     */
    public function class(string $name): string
    {
        switch ($name) {
            case 'news':
                return NewsController::class;
                break;
        }
    }
}