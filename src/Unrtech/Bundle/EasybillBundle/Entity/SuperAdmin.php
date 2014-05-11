<?php
namespace Unrtech\Bundle\EasybillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Unrtech\Bundle\EasybillBundle\Entity\BaseUser as UserBase;

/**
 * Description of super admin
 * @ORM\Table(name="user_super_admin")
 * @ORM\Entity()
 */
class SuperAdmin extends UserBase {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(name="siren", type="string")
     * @var string
     */
    protected $siren;
    
    public function __construct() {
        parent::__construct();
        $this->addRole('SUPER_ADMIN');
        $this->setSuperAdmin(true);
    }
    
    /**
     * Set siren
     * 
     * @param string $siren
     * @return \Unrtech\Bundle\EasybillBundle\Entity\SuperAdmin
     */
    public function setSiren($siren) {
        $this->siren = $siren;
        
        return $this;
    }
    
    /**
     * Get siren
     * 
     * @return string
     */
    public function getSiren() {
        
        return $this->siren;
    }
}