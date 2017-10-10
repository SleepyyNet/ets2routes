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

namespace App\Kernel\CheckForm;

use App\Kernel\SuperGlobals\SuperGlobals;
use DI\Container;

class CheckForm
{
    private $globals;

    public function __construct(Container $container)
    {
        $this->globals = $container->get(SuperGlobals::class);
    }

    /**
     * Cehck form is valid
     * @param string $file
     * @return bool
     */
    public function check(string $file): bool
    {
        $json = json_decode(file_get_contents($file), true);

        foreach ($json as $field => $array) {
            foreach ($array as $key => $val) {
                if (!$this->$key($field, $val)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param $value
     * @param int $size
     * @return bool
     */
    private function maxlength($value, int $size): bool
    {
        if (strlen($this->globals->post()->get($value)) > $size) {
            $this->globals->session()->setError(
                'Le champ <b>'.$value.'</b> doit faire au maximum '.$size.' caractères'
            );
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @param int $size
     * @return bool
     */
    private function minlength($value, int $size): bool
    {
        if (strlen($this->globals->post()->get($value)) < $size) {
            $this->globals->session()->setError(
                'Le champ <b>'.$value.'</b> doit faire au minimum '.$size.' caractères'
            );
            return false;
        }

        return true;
    }
}
