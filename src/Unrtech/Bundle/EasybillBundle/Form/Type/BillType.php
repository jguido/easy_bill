<?php

namespace Unrtech\Bundle\EasybillBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of BillType
 *
 * @author jeremy
 */
class BillType extends AbstractType {

    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('id', 'hidden')
                ->add('reference', null, array('required' => 'true'))
                ->add('taxes', null, array('required' => true))
                ->add('totalHt', null, array('required' => true))
                ->add('status', 'entity', array('required' => true, 'class' => 'Unrtech\Bundle\EasybillBundle\Entity\BillStatus'))
                ->add('payment', 'entity', array('required' => true, 'class' => 'Unrtech\Bundle\EasybillBundle\Entity\Payment'))
//                ->add('customer', 'entity', array('required' => true, 'class' => 'Unrtech\Bundle\EasybillBundle\Entity\Customer'))
                ->add('customer', null, array('required' => true))
                ->add('Enregistrer', 'submit', array('attr' => array('class' => 'btn btn-primary')))
                ->add('Retour', 'button', array('attr' => array('class' => 'btn btn-inverse return-list')))
        ;
    }

    public function getName() {

        return 'bill';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Unrtech\Bundle\EasybillBundle\Entity\BaseBill',
        ));
    }

}
