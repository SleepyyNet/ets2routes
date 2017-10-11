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

namespace App\Kernel\Lang;

class LangManager
{
    private $translation;

    public function __construct(string $lang)
    {
        $this->load('App/Config/Lang/'.$lang.'.json');
    }

    /**
     * Load selected language file
     * @param string $filename
     */
    public function load(string $filename)
    {
        $this->translation = json_decode(file_get_contents($filename), true);
    }

    /**
     * Get translation text
     * @param string $code
     * @return mixed|string
     */
    public function translate(string $code)
    {
        $arrayCode = explode('.', $code);
        $text = $this->translation;

        foreach ($arrayCode as $val) {
            if (!$this->checkTr($text, $val)) {
                return $code;
            }

            $text = $text[$val];
        }

        return $text;
    }

    /**
     * Check if translation is exist
     * @param array $array
     * @param string $key
     * @return bool
     */
    private function checkTr(array $array, string $key): bool
    {
        if (isset($array[$key])) {
            return true;
        }

        return false;
    }
}
