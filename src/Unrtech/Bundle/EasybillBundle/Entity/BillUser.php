<?php
namespace Unrtech\Bundle\EasybillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Unrtech\Bundle\EasybillBundle\Entity\BaseUser as UserBase;
use Unrtech\Bundle\EasybillBundle\Entity\Company;

/**
 * Description of BillUser
 * @ORM\Table(name="user_bill_user")
 * @ORM\Entity()
 */
class BillUser extends UserBase {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var Unrtech\Bundle\EasybillBundle\Entity\Company 
     * 
     * @ORM\ManyToOne(targetEntity="Unrtech\Bundle\EasybillBundle\Entity\Company", inversedBy="users")
     */
    protected $company;
    
    public function __construct() {
        parent::__construct();
        $this->addRole('ROLE_ADMIN');
        $this->setSuperAdmin(false);
    }
    
    /**
     * Set company
     * 
     * @param \Unrtech\Bundle\EasybillBundle\Entity\Company $company
     * 
     * @return \Unrtech\Bundle\EasybillBundle\Entity\BaseUser
     */
    public function setCompany(Company $company) {
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
}