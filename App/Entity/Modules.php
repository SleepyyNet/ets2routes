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

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * Class Modules
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="modules",
 *     indexes={@Index(name="ikey_state", columns={"state"})}
 * )
 */
class Modules
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", options={"default"=false})
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $className;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $version;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set state
     *
     * @param boolean $state
     *
     * @return Modules
     */
    public function setState(bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return boolean
     */
    public function getState(): bool
    {
        return $this->state;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Modules
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set className
     *
     * @param string $className
     *
     * @return Modules
     */
    public function setClassName(string $className): self
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get className
     *
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Modules
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Set version
     *
     * @param string $version
     *
     * @return Modules
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
