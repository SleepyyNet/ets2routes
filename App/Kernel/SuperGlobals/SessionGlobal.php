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
 * Manage $_SESSION SuperGlobal
 * @package App\Kernel\SuperGlobals
 */
class SessionGlobal
{
    private $siteKey = 'ETS2Routes';

    /**
     * Get information in session
     * @param $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        if (isset($_SESSION[$this->siteKey][$key])) {
            return $_SESSION[$this->siteKey][$key];
        }

        return null;
    }

    /**
     * Set information in session
     * @param string $key
     * @param $val
     * @return SessionGlobal
     */
    public function set(string $key, $val): self
    {
        $_SESSION[$this->siteKey][$key] = $val;

        return $this;
    }

    /**
     * Set flash message
     * @param string $type
     * @param string $message
     */
    public function setFlashMessage(string $type, string $message): void
    {
        $_SESSION[$this->siteKey]['_flash'] = $message;
        $_SESSION[$this->siteKey]['_flashtype'] = $type;
    }

    /**
     * Get flash message
     * @return string
     */
    public function getFlashMessage(): string
    {
        if (isset($_SESSION[$this->siteKey]['_flash'])) {
            $flash = $_SESSION[$this->siteKey]['_flash'];
            unset($_SESSION[$this->siteKey]['_flash'], $_SESSION[$this->siteKey]['_flashtype']);
        } else {
            $flash = '';
        }

        return $flash;
    }

    /**
     * get type of actual flash message
     * @return string
     */
    public function getTypeFlashMessage(): string
    {
        if (isset($_SESSION[$this->siteKey]['_flashtype'])) {
            return $_SESSION[$this->siteKey]['_flashtype'];
        }

        return '';
    }

    /**
     * Delete session key
     * @param string $key
     * @return SessionGlobal
     */
    public function delete(string $key): self
    {
        unset($_SESSION[$this->siteKey][$key]);

        return $this;
    }
}
