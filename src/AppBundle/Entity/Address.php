<?php

namespace AppBundle\Entity;

/**
 * Address
 */
class Address
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $street = '';

    /**
     * @var string
     */
    private $postcode = '00-000';

    /**
     * @var string
     */
    private $city = '';

    /**
     * @var boolean
     */
    private $voivodeship = '0';


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
     * Set street
     *
     * @param string $street
     *
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return Address
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set voivodeship
     *
     * @param boolean $voivodeship
     *
     * @return Address
     */
    public function setVoivodeship($voivodeship)
    {
        $this->voivodeship = $voivodeship;

        return $this;
    }

    /**
     * Get voivodeship
     *
     * @return boolean
     */
    public function getVoivodeship()
    {
        return $this->voivodeship;
    }
}
