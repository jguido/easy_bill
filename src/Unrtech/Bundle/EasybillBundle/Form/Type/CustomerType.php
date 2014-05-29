<?php

namespace Unrtech\Bundle\EasybillBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of CustomerType
 *
 * @author jeremy
 */
class CustomerType extends AbstractType{
    
    protected $container;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('id', 'hidden')
                ->add('reference', null, array('required' => true, 'attr' => array('class' => 'col-xs-2')))
                ->add('denomination', null, array('required' => true, 'attr' => array('class' => 'col-xs-3')))
                ->add('phone', null, array('required' => true, 'attr' => array('class' => 'col-xs-3')))
                ->add('mobile', null, array('required' => false, 'attr' => array('class' => 'col-xs-3')))
                ->add('mail', null, array('required' => true, 'attr' => array('class' => 'col-xs-4')))
                ->add('siret', null, array('required' => true, 'attr' => array('class' => 'col-xs-4')))
                ->add('address1', null, array('required' => true, 'attr' => array('class' => 'col-xs-4')))
                ->add('address2', null, array('required' => false, 'attr' => array('class' => 'col-xs-4')))
                ->add('bp', null, array('required' => false, 'attr' => array('class' => 'col-xs-1')))
                ->add('cp', null, array('required' => true, 'attr' => array('class' => 'col-xs-1')))
                ->add('city', null, array('required' => true, 'attr' => array('class' => 'col-xs-2')))
                ->add('country', 'entity', array('required' => true, 'class' => 'Unrtech\Bundle\EasybillBundle\Entity\Country', 'attr' => array('class' => 'col-xs-3')))
                ->add('Enregistrer', 'submit', array('attr' => array('class' => 'btn btn-primary')))
                ->add('Fermer', 'button', array('attr' => array('class' => 'btn btn-inverse return-list')))
                ;
    }
    
    public function getName() {
        
        return 'customer_form';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Unrtech\Bundle\EasybillBundle\Entity\Customer',
        ));
    }
}
