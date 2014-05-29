<?php

namespace Unrtech\Bundle\EasybillBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of CompanyType
 *
 * @author jeremy
 */
class CompanyType extends AbstractType{
    
    protected $container;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('id', 'hidden')
                ->add('name', null, array('required' => true, 'attr' => array('class' => 'col-xs-3')))
                ->add('siren', null, array('required' => true, 'attr' => array('class' => 'col-xs-2')))
                ->add('activity', null, array('required' => false, 'attr' => array('class' => 'col-xs-3')))
                ->add('reference', null, array('required' => true, 'attr' => array('class' => 'col-xs-2')))
                ->add('address1', null, array('required' => true, 'attr' => array('class' => 'col-xs-3')))
                ->add('address2', null, array('required' => false, 'attr' => array('class' => 'col-xs-3')))
                ->add('bp', null, array('required' => false, 'attr' => array('class' => 'col-xs-1')))
                ->add('cp', null, array('required' => true, 'attr' => array('class' => 'col-xs-1')))
                ->add('city', null, array('required' => true, 'attr' => array('class' => 'col-xs-2')))
                ->add('country', 'entity', array('required' => true, 'attr' => array('class' => 'col-xs-2')))
                ->add('Enregistrer', 'submit', array('attr' => array('class' => 'btn btn-primary')))
                ->add('Fermer', 'button', array('attr' => array('class' => 'btn btn-inverse')))
                ;
    }
    
    public function getName() {
        
        return 'company_form';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Unrtech\Bundle\EasybillBundle\Entity\Company',
        ));
    }
}
