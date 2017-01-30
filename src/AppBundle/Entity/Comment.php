<?php

namespace AppBundle\Entity;

/**
 * Comment
 */
class Comment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $created;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Comment
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
    /**
     * @var \AppBundle\Entity\Article
     */
    private $article;


    /**
     * Set article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return Comment
     */
    public function setArticle(\AppBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
    /**
     * @var \AppBundle\Entity\Account
     */
    private $author;


    /**
     * Set author
     *
     * @param \AppBundle\Entity\Account $author
     *
     * @return Comment
     */
    public function setAuthor(\AppBundle\Entity\Account $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\Account
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
