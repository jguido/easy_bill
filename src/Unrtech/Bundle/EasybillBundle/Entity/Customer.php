<?php
namespace Unrtech\Bundle\EasybillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Unrtech\Bundle\EasybillBundle\Entity\BaseUser as UserBase;

/**
 * Description of Customer
 * @ORM\Table(name="user_customer")
 * @ORM\Entity()
 */
class Customer extends UserBase {
    
    /**
     * @var Unrtech\Bundle\EasybillBundle\Entity\Bill
     * 
     * @ORM\OneToMany(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\BaseBill", mappedBy="customer")
     */
    private $bills;
    
    /**
     * @var string
     * @ORM\Column(name="reference", nullable=true)
     */
    protected $reference;
    
    public function __construct() {
        parent::__construct();
    }


    /**
     * Set reference
     *
     * @param string $reference
     * @return Customer
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    
        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }
    
    /**
     * Set bills
     * 
     * @param ArrayCollection $bills
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function setBills(\Doctrine\Common\Collections\ArrayCollection $bills) {
        $this->bills = $bills;
        
        return $this;
    }
    
    /**
     * Add bills
     *
     * @param \Unrtech\Bundle\EasybillBundle\Entity\BaseBill $bills
     * @return Customer
     */
    public function addBill(\Unrtech\Bundle\EasybillBundle\Entity\BaseBill $bills)
    {
        $this->bills[] = $bills;
    
        return $this;
    }

    /**
     * Remove bills
     *
     * @param \Unrtech\Bundle\EasybillBundle\Entity\BaseBill $bills
     */
    public function removeBill(\Unrtech\Bundle\EasybillBundle\Entity\BaseBill $bills)
    {
        $this->bills->removeElement($bills);
    }

    /**
     * Get bills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBills()
    {
        return $this->bills;
    }
}