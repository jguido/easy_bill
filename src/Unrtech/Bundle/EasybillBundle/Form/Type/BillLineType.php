<?php

namespace Unrtech\Bundle\EasybillBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Unrtech\Bundle\EasybillBundle\Form\Transformer\BillTransformer;

/**
 * Description of BillLineType
 *
 * @author jeremy
 */
class BillLineType extends AbstractType{
    
    protected $container;
    protected $parentId;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $billTransformer = new BillTransformer($this->container->get('doctrine.orm.default_entity_manager'));
        $builder
                ->add(
                        $builder->create('bill', 'hidden')
                        ->addModelTransformer($billTransformer)
                )
                ->add('id', 'hidden')
                ->add('service', null, array('required' => true))
                ->add('quantity', null, array('required' => true))
                ->add('unitPrice', 'money', array('required' => true))
                ->add('discount', null, array('required' => false))
                ->add('Enregistrer', 'submit', array('attr' => array('class' => 'btn btn-primary')))
                ->add('Fermer', 'button', array('attr' => array('class' => 'btn btn-inverse data-dismiss close-modal')))
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
