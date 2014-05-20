<?php

namespace Unrtech\Bundle\EasybillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity
 */
class Country
{
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="code", type="string", length=2)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="money_symbol", type="string", length=10, nullable=true)
     */
    private $moneySymbol;

    /**
     * @var string
     *
     * @ORM\Column(name="money_name", type="string", length=50, nullable=true)
     */
    private $moneyName;

    /**
     * @var string
     *
     * @ORM\Column(name="date_format", type="string", length=20, nullable=true)
     */
    private $dateFormat;


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
     * @return Country
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
     * Set moneySymbol
     *
     * @param string $moneySymbol
     * @return Country
     */
    public function setMoneySymbol($moneySymbol)
    {
        $this->moneySymbol = $moneySymbol;
    
        return $this;
    }

    /**
     * Get moneySymbol
     *
     * @return string 
     */
    public function getMoneySymbol()
    {
        return $this->moneySymbol;
    }

    /**
     * Set moneyName
     *
     * @param string $moneyName
     * @return Country
     */
    public function setMoneyName($moneyName)
    {
        $this->moneyName = $moneyName;
    
        return $this;
    }

    /**
     * Get moneyName
     *
     * @return string 
     */
    public function getMoneyName()
    {
        return $this->moneyName;
    }

    /**
     * Set dateFormat
     *
     * @param string $dateFormat
     * @return Country
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    
        return $this;
    }

    /**
     * Get dateFormat
     *
     * @return string 
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }
    
    /**
     * Set code
     *
     * @param string $code
     * @return Country
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
    
    public function __toString() {
        
        return $this->getName();
    }
}