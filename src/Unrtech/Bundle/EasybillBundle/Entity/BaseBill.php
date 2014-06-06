<?php

namespace Unrtech\Bundle\EasybillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Unrtech\Bundle\EasybillBundle\Entity\Customer;
use Unrtech\Bundle\EasybillBundle\Entity\Company;
use Unrtech\Bundle\EasybillBundle\Entity\BillLine;
use Unrtech\Bundle\EasybillBundle\Entity\Payment;
use Unrtech\Bundle\EasybillBundle\Entity\BillStatus;

/**
 * BaseBill
 *
 * @ORM\Table(name="base_bill")
 * @ORM\Entity* @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")

 */
class BaseBill
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
     * @Gedmo\Slug(fields={"reference"}, updatable=false, separator="_")
     * @ORM\Column(name="slug")
     * @var string
     */
    private $slug;

    /**
     * @var \DateTime
     * 
     * @Gedmo\Timestampable(on="create")     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updateDate", type="datetime")
     */
    private $updateDate;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=10, unique=true)
     */
    private $reference;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="taxes", type="float")
     */
    private $taxes;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="total_ht", type="float")
     */
    private $totalHt;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\BillStatus")
     */
    private $status;
    
    /**
     * @var Unrtech\Bundle\EasybillBundle\Entity\Payment
     * 
     * @ORM\ManyToOne(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\Payment")
     */
    private $payment;
    
    /**
     * @var Customer
     * 
     * @ORM\ManyToOne(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\Customer", inversedBy="bills")
     */
    private $customer;
    
    /**
     * @var Company
     * 
     * @ORM\ManyToOne(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\Company", inversedBy="bills")
     */
    private $company;
    
    /**
     * @var Unrtech\Bundle\EasybillBundle\Entity\BillLine
     * 
     * @ORM\OneToMany(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\BillLine", mappedBy="bill")
     * @ORM\OrderBy({"rank" = "ASC"})
     */
    private $lines;
    
    public function __construct() {
        $this->lines = new ArrayCollection();
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
    
    public function setId($id) {
        $this->id = $id;
        
        return $this;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Bill
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Bill
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
    
        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Bill
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
     * Set status
     *
     * @param Unrtech\Bundle\EasybillBundle\Entity\BillStatus $status
     * 
     * @return Bill
     */
    public function setStatus(BillStatus $status = null)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return Unrtech\Bundle\EasybillBundle\Entity\BillStatus 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return BaseBill
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
     * Set taxes
     *
     * @param float $taxes
     * @return BaseBill
     */
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;
    
        return $this;
    }

    /**
     * Get taxes
     *
     * @return float 
     */
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * Set totalHt
     *
     * @param float $totalHt
     * @return BaseBill
     */
    public function setTotalHt($totalHt)
    {
        $this->totalHt = $totalHt;
    
        return $this;
    }

    /**
     * Get totalHt
     *
     * @return float 
     */
    public function getTotalHt()
    {
        return $this->totalHt;
    }
    
    /**
     * Compute the total of the lines
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BaseBill
     */
    public function computeTotalHt() {
        if (count($this->lines) > 0) {
            foreach ($this->lines as $line) {
                $tmpPrice = floatval($line->getUnitPrice()) * floatval($line->getQuantity());
                $this->totalHt +=  $tmpPrice - ($tmpPrice * floatval($line->getDiscount()));
            }
        }
        
        return $this;
    }

    /**
     * Set payment
     *
     * @param \Unrtech\Bundle\EasybillBundle\Entity\Payment $payment
     * @return BaseBill
     */
    public function setPayment(Payment $payment = null)
    {
        $this->payment = $payment;
    
        return $this;
    }

    /**
     * Get payment
     *
     * @return \Unrtech\Bundle\EasybillBundle\Entity\Payment 
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set customer
     * 
     * @param \Unrtech\Bundle\EasybillBundle\Entity\Customer $customer
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BaseBill
     */
    public function setCustomer(Customer $customer = null){
        $this->customer = $customer;
        
        return $this;
    }
    
    /**
     * Get customer
     * 
     * @return Unrtech\Bundle\EasybillBundle\Entity\Customer
     */
    public function getCustomer() {
        
        return $this->customer;
    }

    /**
     * Set company
     * 
     * @param \Unrtech\Bundle\EasybillBundle\Entity\Company $company
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BaseBill
     */
    public function setCompany(Company $company = null){
        $this->company = $company;
        
        return $this;
    }
    
    /**
     * Get company
     * 
     * @return Unrtech\Bundle\EasybillBundle\Entity\Company
     */
    public function getCompany() {
        
        return $this->company;
    }
    
    /**
     * Set lines
     * 
     * @param \Doctrine\Common\Collections\ArrayCollection $lines
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BaseBill
     */
    public function setLines(ArrayCollection $lines) {
        if (count($lines) > 0) {
            foreach ($lines as $line) {
                $this->addLine($line);
            }
        }
        
        return $this;
    }
    
    /**
     * Add one line
     * 
     * @param \Unrtech\Bundle\EasybillBundle\Entity\Unrtech\Bundle\EasybillBundle\Entity\BillLine $line
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BaseBill
     */
    public function addLine(BillLine $line) {
        $line->setBill($this);
        $this->lines->add($line);
        
        return $this;
    }
    
    /**
     * Remove one line
     * 
     * @param \Unrtech\Bundle\EasybillBundle\Entity\Unrtech\Bundle\EasybillBundle\Entity\BillLine $line
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BaseBill
     */
    public function removeLine(BillLine $line) {
        $this->lines->removeElement($line);
        
        return $this;
    }
    
    /**
     * Clear all lines
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BaseBill
     */
    public function clearLines() {
        $this->lines->clear();
        
        return $this;
    }
    
    /**
     * Get all lines
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getLines() {
        
        return $this->lines;
    }
}