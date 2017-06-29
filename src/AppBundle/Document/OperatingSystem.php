<?php
namespace AppBundle\Document;


class OperatingSystem implements DocumentInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $osName;

    /**
     * @var int
     */
    private $num;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getOsName(): string
    {
        return $this->osName;
    }

    /**
     * @param string $osName
     */
    public function setOsName(string $osName)
    {
        $this->osName = $osName;
    }

    /**
     * @return int
     */
    public function getNum(): int
    {
        return $this->num;
    }

    /**
     * @param int $num
     */
    public function setNum(int $num)
    {
        $this->num = $num;
    }
}