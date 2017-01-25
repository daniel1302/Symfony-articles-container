<?php

namespace AppBundle\Entity;

 use Doctrine\ORM\Mapping as ORM;
 use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Account
 */
 class Account implements UserInterface, \Serializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username = '';

    /**
     * @var string
     */
    private $pass = '';

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var \AppBundle\Entity\Address
     */
    private $address;
    
    /**
     * @var string
     */
    private $role = '';
    
    /**
     * @var string
     */
    private $firstname = '';
    
    /**
     * @var string
     */
    private $surname = '';
    
    /**
     * @var string
     */
    private $plainPassword = '';

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
     * Set username
     *
     * @param string $username
     *
     * @return Account
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return Account
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Account
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\Address $address
     *
     * @return Account
     */
    public function setAddress(\AppBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set roles
     *
     * @param string $roles
     *
     * @return User
     */
    public function setRole($role): self
    {
        $this->role = json_encode($role);

        return $this;
    }

    /**
     * Get roles
     *
     * @return string
     */
    public function getRole(): array
    {   
        $role = json_decode($this->role, true);
        if (!is_array($role)) {
            return ['ROLE_ADMIN'];
        }
        return $role;
    }

    public function getSalt(): string {
        return '';
    }
    
    public function setFirstname(string $firstname): self 
    {
        $this->firstname = $firstname;
        
        return $this;
    }
    
    public function getFirstname(): string {
        return $this->firstname;
    }
    
    public function setSurname(string $surname): self 
    {
        $this->surname = $surname;
        
        return $this;
    }
    
    public function getSurname(): string {
        return $this->surname;
    }
    
    public function setPlainPassword($pass): self {
        if ($pass === null) {
            $pass = '';
        }

        $this->plainPassword = $pass;
        
        return $this;
    }
    
    public function getPlainPassword(): string {
        return $this->plainPassword;
    }
    
    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->pass,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->pass,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
    
    public function getRoles() {
        
        return $this->getRole();
    }

    public function getPassword(): string {
        return $this->pass;
    }
    
    
    public function __toString() {
        return $this->username;
    }
}
