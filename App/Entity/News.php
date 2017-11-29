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
use App\Entity\NewsCat;
use App\Entity\User;

/**
 * Class News
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="news",
 *     indexes={
 *      @ORM\Index(name="ikey_category", columns={"category"}),
 *      @ORM\Index(name="ikey_author", columns={"author"})
 *     }
 * )
 */
class News
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="NewsCat")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\Column(name="post_date", type="date")
     */
    private $postDate;

    /**
     * @ORM\Column(name="change_date", type="datetime", nullable=true)
     */
    private $changeDate;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

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
     * Set postDate
     *
     * @param \DateTime $postDate
     *
     * @return News
     */
    public function setPostDate(\DateTime $postDate): self
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime
     */
    public function getPostDate(): \DateTime
    {
        return $this->postDate;
    }

    /**
     * Set changeDate
     *
     * @param \DateTime $changeDate
     *
     * @return News
     */
    public function setChangeDate(\DateTime $changeDate): self
    {
        $this->changeDate = $changeDate;

        return $this;
    }

    /**
     * Get changeDate
     *
     * @return \DateTime
     */
    public function getChangeDate(): \DateTime
    {
        return $this->changeDate;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return News
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return News
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return News
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Set category
     *
     * @param NewsCat $category
     *
     * @return News
     */
    public function setCategory(NewsCat $category = null): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return NewsCat
     */
    public function getCategory(): NewsCat
    {
        return $this->category;
    }

    /**
     * Set author
     *
     * @param User $author
     *
     * @return News
     */
    public function setAuthor(User $author = null): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }
}
