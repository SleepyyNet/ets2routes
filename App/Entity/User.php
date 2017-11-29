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

use DI\Annotation\Inject;
use Doctrine\ORM\Mapping as ORM;

/**
 * User entity
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="user",
 *     indexes={
 *      @ORM\Index(name="ikey_user_group", columns={"user_group"})
 *      },
 *     uniqueConstraints={
 *      @ORM\UniqueConstraint(name="ukey_login", columns={"login"}),
 *      @ORM\UniqueConstraint(name="ukey_validation_code", columns={"validation_code"})
 *     }
 * )
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="integer", options={"unsigned"=true}, name="user_group")
     */
    private $userGroup;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=32, nullable=true, name="validation_code")
     */
    private $validationCode;

    /**
     * @ORM\Column(type="date", name="register_date")
     */
    private $registerDate;

    /**
     * @ORM\Column(type="datetime", name="last_login")
     */
    private $lastLogin;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default"=0})
     */
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
        $this->password = hash('sha256', $password);

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
        return $this->registerDate;
    }

    /**
     * @param date $registerDate
     * @return User
     */
    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param date $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

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
        $this->validate = $validate;

        return $this;
    }
}
