<?php

namespace Unrtech\Bundle\EasybillBundle\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Unrtech\Bundle\EasybillBundle\Entity\BaseBill;
use Unrtech\Bundle\EasybillBundle\Entity\BillLine;
use Unrtech\Bundle\EasybillBundle\Entity\BillStatus;
use Unrtech\Bundle\EasybillBundle\Entity\Payment;
use Unrtech\Bundle\EasybillBundle\Entity\Address;
use Unrtech\Bundle\EasybillBundle\Entity\Customer;

/**
 * Description of StatusFixtures
 *
 * @author jeremy
 */
class LoadBillData implements FixtureInterface {

    private $arrStatus = array(
        'CREATE' => 'Created',
        'SENT' => 'Sent',
        'PAY' => 'Payed',
    );
    private $arrPayment = array(
        'CB' => 'Carte de crédit',
        'VIR' => 'Virement',
        'ESP' => 'Espèce',
        'CHE' => 'Chèque',
    );
    private $customers;

    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        
        foreach (range(1, 10) as $a) {
            $address = new Address();
            $address
                    ->setAddress1($a.', rue x')
                    ->setAddress2('le truc')
                    ->setPostCode('06400')
                    ->setCity('Cannes');
            $manager->persist($address);
            $customer = new Customer();
            $customer
                    ->setReference('ref-123-'.$a)
                    ->setDenomination('customer-'.$a)
                    ->SetPhone('0494949494')
                    ->SetMobile('0606060606')
                    ->setMail('customer'.$a.'@mail.fr')
                    ->setSiret('12345678900011')
                    ->setAddress($address);
            $manager->persist($customer);
        }
        
        foreach ($this->arrStatus as $code => $name) {
            $status = new BillStatus();
            $status
                    ->setCode($code)
                    ->setName($name);

            $manager->persist($status);
        }
        foreach ($this->arrPayment as $code => $name) {
            $payment = new Payment();
            $payment
                    ->setCode($code)
                    ->setName($name);
            $manager->persist($payment);
        }

        $manager->flush();

        $this->arrStatus = $manager->getRepository('UnrtechEasybillBundle:BillStatus')->findAll();
        $this->arrPayment = $manager->getRepository('UnrtechEasybillBundle:Payment')->findAll();
        $this->customers = $manager->getRepository('UnrtechEasybillBundle:Customer')->findAll();
        
        foreach (range(0, 10) as $i) {
            $bill = new BaseBill();
            $bill
                    ->setCustomer($this->customers[mt_rand(0, count($this->arrPayment)-1)])
                    ->setPayment($this->arrPayment[mt_rand(0, count($this->arrPayment)-1)])
                    ->setReference('1234-'.$i)
                    ->setStatus($this->arrStatus[mt_rand(0, count($this->arrStatus)-1)])
                    ->setTaxes(0.196)
                    ->setTotalHt(0);
            
            $manager->persist($bill);
            foreach (range(0, 10) as $j) {
                $qty = mt_rand(1, 10);
                $unity = mt_rand(10, 200);
                $discount = mt_rand(0, 100)/100;
                $billLine = new BillLine();
                $billLine
                        ->setService('service-'.$i.'-'.$j)
                        ->setQuantity($qty)
                        ->setUnitPrice($unity)
                        ->setDiscount($discount);

                $manager->persist($billLine);
                
                $bill->addLine($billLine);
            }
            $bill->computeTotalHt();
        }
        
        $manager->flush();
    }

}

?>
