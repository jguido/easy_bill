<?php

namespace Unrtech\Bundle\EasybillBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Unrtech\Bundle\EasybillBundle\Entity\BaseBill;

/**
 * Description of BillTransformer
 *
 * @author jeremy
 */
class BillTransformer implements DataTransformerInterface{
    private $om;
    
    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }

    public function reverseTransform($id) {
        if (!$id) {
            return null;
        }
        
        $bill = $this->om->getRepository('UnrtechEasybillBundle:BaseBill')->find($id);
        
        if (null === $bill) {
            throw new TransformationFailedException(sprintf('A bill with id "%s" does not exists!', $id));
        }
        
        return $bill;
    }

    public function transform($bill) {
        if (null === $bill) {
            return "";
        }
        
        return $bill->getId();
    }

}
