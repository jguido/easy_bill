<?php

namespace Unrtech\Bundle\EasybillBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of BillLineType
 *
 * @author jeremy
 */
class BillLineType extends AbstractType{
    
    protected $container;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('service', null, array('required' => 'true'))
                ->add('quantity', null, array('required' => true))
                ->add('unitPrice', 'money', array('required' => true))
                ->add('discount', null, array('required' => false))                
                ->add('submit', 'submit', array('attr' => array('class' => 'btn btn-primary')))
                ->add('annuler', 'reset', array('attr' => array('class' => 'btn btn-inverse')))
                ;
    }
    
    public function getName() {
        
        return 'bill_line';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Unrtech\Bundle\EasybillBundle\Entity\BillLine',
        ));
    }
}
