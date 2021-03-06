<?php

namespace Unrtech\Bundle\EasybillBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of FormHandler
 *
 * @author jeremy
 */
class FormHandler {

    protected $_request;
    protected $_form;
    protected $_page;
    protected $_container;

    public function __construct(Form $form, Request $request, ContainerInterface $container) {
        $this->_form = $form;
        $this->_request = $request;
        $this->_container = $container;
    }

    public function process() {
        $result = false;
        if ($this->_form->isValid()) {

            $result = $this->onSuccess($this->_form->getData());
        }
        
        return $result;
    }

    public function onSuccess($data) {
        if (null === $data) {
            throw new \Symfony\Component\Process\Exception\ProcessFailedException('Data is null');
        }
        
        $em = $this->_container->get('doctrine.orm.entity_manager');
        
        if (null === $data->getId()) {
            $em->persist($data);
        }
        
        $em->flush();
        
        return $data;
    }

}

?>
