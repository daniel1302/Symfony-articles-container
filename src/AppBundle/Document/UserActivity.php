<?php
namespace AppBundle\Document;


class UserActivity
{
    /**
     * @var float
     */
    private $uTime;

    /**
     * @var string
     */
    private $sessionId;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $page;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * @return float
     */
    public function getUTime()
    {
        return $this->uTime;
    }

    /**
     * @param float $uTime
     */
    public function setUTime($uTime)
    {
        $this->uTime = $uTime;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param string $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }
}