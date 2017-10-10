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

namespace App\Kernel\SuperGlobals;

/**
 * Manage $_POST SuperGlobal
 * @package App\Kernel\SuperGlobals
 */
class PostGlobal
{
    /**
     * GET $_POST key
     * @param mixed $key
     * @return mixed|null
     */
    public function get($key)
    {
        if (isset($_POST[$key])) {
            return $_POST[$key];
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isSubmit(): bool
    {
        return !empty($_POST);
    }

    /**
     * @param $key
     * @return bool
     */
    public function isNull($key): bool
    {
        return is_null($_POST[$key]);
    }

    /**
     * @param $key
     * @return bool
     */
    public function isInt($key): bool
    {
        return is_int($_POST[$key]);
    }

    /**
     * @param $key
     * @return bool
     */
    public function isBool($key): bool
    {
        return is_bool($_POST[$key]);
    }

    /**
     * @param $key
     * @return bool
     */
    public function isString($key): bool
    {
        return is_string($_POST[$key]);
    }

    /**
 * @param $key
 * @return bool
 */
    public function isNumeric($key): bool
    {
        return is_numeric($_POST[$key]);
    }

    /**
     * @param $key
     * @return bool
     */
    public function isFloat($key): bool
    {
        return is_float($_POST[$key]);
    }
}
