<?php
namespace Unrtech\Bundle\EasybillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @var UnrTech\Bundle\EasybillBundle\Entity\Address
     * @ORM\ManyToOne(targetEntity="UnrTech\Bundle\EasybillBundle\Entity\Address", cascade={"persist"})
     */
    private $address;
    

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
     * Set address
     *
     * @param \UnrTech\Bundle\EasybillBundle\Entity\Address $address
     * @return Company
     */
    public function setAddress(\UnrTech\Bundle\EasybillBundle\Entity\Address $address = null)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return \UnrTech\Bundle\EasybillBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    public function __toString() {
        
        return $this->getName();
    }
}