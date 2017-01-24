<?php

namespace AppBundle\Entity;

/**
 * AccountQuestion
 */
class AccountQuestion
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $question;

    /**
     * @var \DateTime
     */
    private $fillDate;

    /**
     * @var string
     */
    private $answer;


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
     * Set account
     *
     * @param string $account
     *
     * @return AccountQuestion
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set question
     *
     * @param string $question
     *
     * @return AccountQuestion
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set fillDate
     *
     * @param \DateTime $fillDate
     *
     * @return AccountQuestion
     */
    public function setFillDate($fillDate)
    {
        $this->fillDate = $fillDate;

        return $this;
    }

    /**
     * Get fillDate
     *
     * @return \DateTime
     */
    public function getFillDate()
    {
        return $this->fillDate;
    }


    /**
     * @var integer
     */
    private $points;


    /**
     * Set points
     *
     * @param integer $points
     *
     * @return AccountQuestion
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return integer
     */
    public function getQuestionId()
    {
        return $this->getQuestion()->getId();
    }
}
