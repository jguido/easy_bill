<?php
namespace Unrtech\Bundle\EasybillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Unrtech\Bundle\EasybillBundle\Entity\BaseBill;
use Unrtech\Bundle\EasybillBundle\Entity\Country;

/**
 * Description of Customer
 * @ORM\Table(name="customer")
 * @ORM\Entity()
 */
class Customer {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="denomination", type="string", length=100)
     */
    private $denomination;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="phone", type="string", length=15)
     */
    private $phone;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="mobile", type="string", length=15, nullable=true)
     */
    private $mobile;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="siret", type="string", length=15)
     */
    private $siret;
    
    /**
     * @var string
     * @ORM\Column(name="reference", nullable=true)
     */
    protected $reference;
    
    /**
     * @var Unrtech\Bundle\EasybillBundle\Entity\Bill
     * 
     * @ORM\OneToMany(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\BaseBill", mappedBy="customer")
     */
    private $bills;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="address_1", type="string", length=255)
     */
    private $address1;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="address_2", type="string", length=255, nullable=true)
     */
    private $address2;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="bp", type="string", length=255, nullable=true)
     */
    private $bp;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="cp", type="string", length=255)
     */
    private $cp;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;
    
    /**
     * @var Unrtech\Bundle\EasybillBundle\Entity\Country
     * 
     * @ORM\ManyToOne(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\Country")
     */
    private $country;
    
    public function __construct() {
        $this->bills = new ArrayCollection();
    }
    
    public function setId($id) {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * Get the id
     * 
     * @return integer
     */
    public function getId() {
        
        return $this->id;
    }
    
    /**
     * Set the denomination
     * 
     * @param string $denomination
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function setDenomination($denomination) {
        $this->denomination = $denomination;
        
        return $this;
    }
    
    /**
     * Get the denomination
     * 
     * @return string
     */
    public function getDenomination() {
        
        return $this->denomination;
    }
    
    /**
     * Set the phone
     * 
     * @param string $phone
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        
        return $this;
    }
    
    /**
     * Get the phone
     * 
     * @return string
     */
    public function getPhone() {
        
        return $this->phone;
    }
    
    /**
     * Set the mobile
     * 
     * @param string $mobile
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;
        
        return $this;
    }
    
    /**
     * Get the mobile
     * 
     * @return string
     */
    public function getMobile() {
        
        return $this->mobile;
    }
    
    /**
     * Set the mail
     * 
     * @param string $mail
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function setMail($mail) {
        $this->mail = $mail;
        
        return $this;
    }
    
    /**
     * Get the mail
     * 
     * @return string
     */
    public function getMail() {
        
        return $this->mail;
    }
    
    
    /**
     * Set siret
     *
     * @param string $siret
     * @return Customer
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;
    
        return $this;
    }

    /**
     * Get siret
     *
     * @return string 
     */
    public function getSiret()
    {
        return $this->siret;
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
    public function addBill(BaseBill $bills)
    {
        $this->bills[] = $bills;
    
        return $this;
    }

    /**
     * Remove bills
     *
     * @param \Unrtech\Bundle\EasybillBundle\Entity\BaseBill $bills
     */
    public function removeBill(BaseBill $bills)
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
    
    /**
     * Clear all bills
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function clearBills() {
        $this->bills->clear();
        
        return $this;
    }
    
    /**
     * Set address1
     * 
     * @param string $adr
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function setAddress1($adr) {
        $this->address1 = $adr;
        
        return $this;
    }
    
    /**
     * Get address1
     * 
     * @return string
     */
    public function getAddress1() {
        
        return $this->address1;
    }
    
    /**
     * Set address2
     * 
     * @param string $adr
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function setAddress2($adr) {
        $this->address2 = $adr;
        
        return $this;
    }
    
    /**
     * Get address2
     * 
     * @return string
     */
    public function getAddress2() {
        
        return $this->address2;
    }
    
    /**
     * Set BP
     * 
     * @param string $bp
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function setBp($bp) {
        $this->bp = $bp;
        
        return $this;
    }
    
    /**
     * Get BP
     * 
     * @return string
     */
    public function getBp() {
        
        return $this->bp;
    }
    
    /**
     * Set CP
     * 
     * @param string $cp
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function setCp($cp) {
        $this->cp = $cp;
        
        return $this;
    }
    
    /**
     * Get CP
     * 
     * @return string
     */
    public function getCp() {
        
        return $this->cp;
    }
    
    /**
     * Set city
     * 
     * @param string $city
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function setCity($city) {
        
        $this->city = $city;
        
        return $this;
    }
    
    /**
     * Get city
     * 
     * @return string
     */
    public function getCity() {
        
        return $this->city;
    }

    /**
     * Set country
     *
     * @param \UnrTech\Bundle\EasybillBundle\Entity\Country $country
     * 
     * @return Customer
     */
    public function setCountry(Country $country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return \UnrTech\Bundle\EasybillBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    public function __toString() {

        return $this->denomination;
    }
}