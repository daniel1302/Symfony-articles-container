<?php

namespace AppBundle\Entity;

/**
 * Answer
 */
class Answer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $idQuestion;

    /**
     * @var boolean
     */
    private $valid;

    /**
     * @var \AppBundle\Entity\Account
     */
    private $author;

    /**
     * @var \AppBundle\Entity\Question
     */
    private $question;
    
    /**
     * @var integer
     */
    private $orderNo;

    /**
     * Get id
     *
     * @return integer
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
     * @return Answer
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
     * Set idQuestion
     *
     * @param integer $idQuestion
     *
     * @return Answer
     */
    public function setIdQuestion($idQuestion)
    {
        $this->idQuestion = $idQuestion;

        return $this;
    }

    /**
     * Get idQuestion
     *
     * @return integer
     */
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }

    /**
     * Set valid
     *
     * @param boolean $valid
     *
     * @return Answer
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
    }


    /**
     * Set author
     *
     * @param \AppBundle\Entity\Account $author
     *
     * @return Answer
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

    /**
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Answer
     */
    public function setQuestion(\AppBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \AppBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    public function setOrderNo($orderNo = null)
    {
        $this->orderNo = $orderNo;

        return $this;
    }

    public function getOrderNo()
    {
        return $this->orderNo;
    }
}
