<?php

namespace AppBundle\Entity;

/**
 * QuestionAnswer
 */
class QuestionAnswer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $points;

    /**
     * @var \AppBundle\Entity\Answer
     */
    private $answer;

    /**
     * @var \AppBundle\Entity\AccountQuestion
     */
    private $question;


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
     * Set answer
     *
     * @param \AppBundle\Entity\Answer $answer
     *
     * @return QuestionAnswer
     */
    public function setAnswer(\AppBundle\Entity\Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \AppBundle\Entity\Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set question
     *
     * @param \AppBundle\Entity\AccountQuestion $question
     *
     * @return QuestionAnswer
     */
    public function setQuestion(\AppBundle\Entity\AccountQuestion $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \AppBundle\Entity\AccountQuestion
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
