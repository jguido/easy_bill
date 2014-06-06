<?php

namespace Unrtech\Bundle\EasybillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Unrtech\Bundle\EasybillBundle\Entity\BaseBill;

/**
 * BillLine
 *
 * @ORM\Table(name="bill_line")
 * @ORM\Entity
 */
class BillLine
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
     * @var int
     * 
     * @ORM\Column(name="rank", type="integer", nullable=false)
     */
    private $rank;
    
    /**
     * @ORM\Column(name="service", type="string", length=255)
     *
     * @var string
     */
    private $service;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;
    
    /**
     * @var decimal
     * 
     * @ORM\Column(name="unit_price", type="float")
     */
    private $unitPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="discount", type="float")
     */
    private $discount;
    
    /**
     * @var Unrtech\Bundle\EasybillBundle\Entity\BaseBill 
     * 
     * @ORM\ManyToOne(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\BaseBill", inversedBy="lines")
     */
    private $bill;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }
    
    /**
     * Set the rank of the line
     * 
     * @param int $rank
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BillLine
     */
    public function setRank($rank) {
        $this->rank = $rank;
        
        return $this;
    }
    
    /**
     * set service
     * 
     * @param string $service
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BillLine
     */
    public function setService($service) {
        $this->service = $service;
        
        return $this;
    }
    
    /**
     * get service
     * 
     * @return string
     */
    public function getService() {
        
        return $this->service;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return BillLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     * set unit price
     * 
     * @param decimal $p
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BillLine
     */
    public function setUnitPrice($p) {
        $this->unitPrice = $p;
        
        return $this;
    }
    
    /**
     * get unit price
     * 
     * @return decimal
     */
    public function getUnitPrice() {
        
        return $this->unitPrice;
    }

    /**
     * Set discount
     *
     * @param float $discount
     * @return BillLine
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    
        return $this;
    }

    /**
     * Get discount
     *
     * @return float 
     */
    public function getDiscount()
    {
        return $this->discount;
    }
    
    /**
     * Set bill
     * 
     * @param \Unrtech\Bundle\EasybillBundle\Entity\Unrtech\Bundle\EasybillBundle\Entity\BaseBill $bill
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BillLine
     */
    public function setBill(BaseBill $bill) {
        $this->bill = $bill;
        
        return $this;
    }
    
    /**
     * Get the bill
     * 
     * @return Unrtech\Bundle\EasybillBundle\Entity\BaseBill
     */
    public function getBill() {
        
        return $this->bill;
    }
}
