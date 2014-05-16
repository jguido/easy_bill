<?php

namespace Unrtech\Bundle\EasybillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as FosBaseUser;

/**
 * User
 *
 * @ORM\Table(name="user_base")
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"super_admin" = "SuperAdmin"})
 */
abstract class BaseUser extends FosBaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    protected $firstname;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    protected $lastname;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="telephone", nullable=true)
     */
    protected $telephone;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="mobile", nullable=true)
     */
    protected $mobile;
    
    /**
     * @var Unrtech\Bundle\EasybillBundle\Entity\Address
     * 
     * @ORM\ManyToOne(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\Address")
     */
    protected $billingAddress;


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
     * Set billingAddress
     *
     * @param \Unrtech\Bundle\EasybillBundle\Entity\Address $billingAddress
     * @return User
     */
    public function setBillingAddress(\Unrtech\Bundle\EasybillBundle\Entity\Address $billingAddress = null)
    {
        $this->billingAddress = $billingAddress;
    
        return $this;
    }

    /**
     * Get billingAddress
     *
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Address 
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return BaseUser
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return BaseUser
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return BaseUser
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    
        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return BaseUser
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }
}