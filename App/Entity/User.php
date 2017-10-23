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

namespace App\Entity;

/**
 * User entity
 * @package App\Entity
 */
class User
{
    private $id;
    private $userGroup;
    private $login;
    private $password;
    private $mail;
    private $validationCode;
    private $registerDate;
    private $lastLogin;
    private $validate;

    public function __construct()
    {
        $this->registerDate = new \DateTime();
        $this->lastLogin = new \DateTime();
        $this->setValidate(false);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserGroup()
    {
        return $this->userGroup;
    }

    /**
     * @param int $userGroup
     * @return User
     */
    public function setUserGroup(int $userGroup)
    {
        $this->userGroup = $userGroup;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return User
     */
    public function setLogin(string $login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     * @return User
     */
    public function setMail(string $mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return string
     */
    public function getValidationCode()
    {
        return $this->validationCode;
    }

    /**
     * @param string $validationCode
     * @return User
     */
    public function setValidationCode($validationCode)
    {
        $this->validationCode = $validationCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getRegisterDate()
    {
        return $this->registerDate->format('Y-m-d');
    }

    /**
     * @param string $registerDate
     * @return User
     */
    public function setRegisterDate(string $registerDate)
    {
        $this->registerDate = date_create($registerDate);

        return $this;
    }

    /**
     * @return string
     */
    public function getLastLogin()
    {
        return $this->lastLogin->format('Y-m-d H:i:s');
    }

    /**
     * @param string $lastLogin
     * @return User
     */
    public function setLastLogin(string $lastLogin)
    {
        $this->lastLogin = date_create($lastLogin);

        return $this;
    }

    /**
     * @return bool
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * @param bool $validate
     * @return User
     */
    public function setValidate(bool $validate)
    {
        $this->validate = (int)$validate;

        return $this;
    }
}
