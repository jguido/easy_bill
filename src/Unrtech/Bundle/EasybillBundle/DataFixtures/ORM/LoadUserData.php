<?php
namespace Unrtech\Bundle\EasybillBundle\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Unrtech\Bundle\EasybillBundle\Entity\SuperAdmin;
use Unrtech\Bundle\EasybillBundle\Entity\Address;

/**
 * Description of UserFixtures
 *
 * @author jeremy
 */
class LoadUserData implements FixtureInterface{
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        $address = new Address();
        $address
                ->setAddress1('218, Chemin du Parrou')
                ->setPostCode('06560')
                ->setCity('Valbonne');
        $superAdmin = new SuperAdmin();
        $superAdmin
                ->setBillingAddress($address)
                ->setFirstname('Laura')
                ->setLastname('Grimaldi')
                ->setUsername('admin')
                ->setEmail('laura.grimaldi1@gmail.com')
                ->setSiren('509 156 741')
                ->setPlainPassword('admin')
                ->setEnabled(true);
        
        $manager->persist($address);
        $manager->persist($superAdmin);
        
        $manager->flush();
    }
}

?>
