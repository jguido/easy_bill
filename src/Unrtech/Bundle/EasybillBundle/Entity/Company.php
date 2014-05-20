<?php
namespace Unrtech\Bundle\EasybillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Unrtech\Bundle\EasybillBundle\Entity\Country;
use Doctrine\Common\Collections\ArrayCollection;
use Unrtech\Bundle\EasybillBundle\Entity\BillUser;

/**
 * Description of Customer
 * @ORM\Table(name="company")
 * @ORM\Entity()
 *
 */
class Company {
    
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
     * @ORM\Column(name="name")
     */
    private $name;
    
    /**
     * @var string
     * @ORM\Column(name="siren")
     */
    private $siren;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="activity", type="string", length=255, nullable=true)
     */
    private $activity;
    
    /**
     * @var string
     * @ORM\Column(name="reference")
     */
    private $reference;
    
    /**
     * @Gedmo\Slug(fields={"name", "siren", "reference"})
     * @ORM\Column(name="slug")
     * @var string
     */
    private $slug;
    
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
     * @var UnrTech\Bundle\EasybillBundle\Entity\Country
     * 
     * @ORM\ManyToOne(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\Country")
     */
    private $country;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\BillUser", mappedBy="company")
     */
    private $users;
    
    public function __construct() {
        $this->users = new ArrayCollection();
    }
    

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
     * Set name
     *
     * @param string $name
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set siren
     *
     * @param string $siren
     * @return Company
     */
    public function setSiren($siren)
    {
        $this->siren = $siren;
    
        return $this;
    }

    /**
     * Get siren
     *
     * @return string 
     */
    public function getSiren()
    {
        return $this->siren;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Company
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
     * Set slug
     *
     * @param string $slug
     * @return Company
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * Set address1
     * 
     * @param string $adr
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Company
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
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Company
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
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Company
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
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Company
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
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Company
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
     * @return Company
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
    
    /**
     * Set users
     * 
     * @param ArrayCollection $users
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Company
     */
    public function setUsers($users) {
        if (count($users) > 0) {
            foreach ($users as $user) {
                $this->addUser($user);
            }
        }
        
        return $this;
    }
    
    /**
     * Add one user
     * 
     * @param \Unrtech\Bundle\EasybillBundle\Entity\BillUser $user
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Company
     */
    public function addUser(BillUser $user) {
        $user->setCompany($this);
        $this->users->add($user);
        
        return $this;
    }
    
    /**
     * Remove one user
     * 
     * @param \Unrtech\Bundle\EasybillBundle\Entity\BillUser $user
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Company
     */
    public function removeUSer(BillUser $user) {
        $this->users->removeElement($user);
        
        return $this;
    }
    
    /**
     * Clear all users
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Company
     */
    public function clearUSers() {
        $this->users->clear();
        
        return $this;
    }
    
    /**
     * Get all users
     * 
     * @return ArrayCollection
     */
    public function getUsers() {
        
        return $this->users;
    }
    
    public function __toString() {
        
        return $this->getName();
    }
}