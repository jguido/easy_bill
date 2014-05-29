<?php

namespace Unrtech\Bundle\EasybillBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of BillUserType
 *
 * @author jeremy
 */
class BillUserType extends AbstractType {

    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('id', 'hidden')
                ->add('firstname', null, array('required' => true))
                ->add('lastname', null, array('required' => true))
                ->add('email', null, array('required' => true))
                ->add('telephone', null, array('required' => false))
                ->add('mobile', null, array('required' => false))
                ->add('password', 'repeated', array(
                    'required' => false, 
                    'type' => 'password', 
                    'first_options'  => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Mot de passe (validation)'),))
        ;
    }

    public function getName() {

        return 'bill';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Unrtech\Bundle\EasybillBundle\Entity\BillUser',
        ));
    }

}
