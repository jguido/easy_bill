<?php

namespace Unrtech\Bundle\EasybillBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unrtech\Bundle\EasybillBundle\Entity\BaseBill;
use Unrtech\Bundle\EasybillBundle\Form\Type\BillType;
use Unrtech\Bundle\EasybillBundle\Entity\BillLine;
use Unrtech\Bundle\EasybillBundle\Form\Type\BillLineType;
use Unrtech\Bundle\EasybillBundle\Form\Handler\FormHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class FormController extends Controller {

    /**
     * @Route("/form/render/bill/create", name="path_form_bill_create")
     */
    public function billCreateAction(Request $request) {
        $_em = $this->getDoctrine()->getManager();
        $object = new BaseBill();
        
        $form = $this->createForm(new BillType($this->container), $object);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $_em->persist($object);
            $_em->flush();
            
            return $this->redirect($this->generateUrl('path_view_bill', array(
                'id' => $object->getId()
            )));
        }

        return $this->render('UnrtechEasybillBundle:Form:form_bill.html.twig', array(
            'form' => $form->createView(),
            'action' => 'create'
        ));
    }

    /**
     * @Route("/form/render/bill/{id}", name="path_form_bill_edit")
     */
    public function billEditAction(Request $request, $id) {
        $_em = $this->getDoctrine()->getManager();
        $object = $_em->getRepository('UnrtechEasybillBundle:BaseBill')->find($id);
        
        $form = $this->createForm(new BillType($this->container), $object);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $_em->flush();
            
            return $this->redirect($this->generateUrl('path_view_bill', array(
                'id' => $id
            )));
        }

        return $this->render('UnrtechEasybillBundle:Form:form_bill.html.twig', array(
            'form' => $form->createView(),
            'action' => 'edit',
            'id' => $id
        ));
    }

    /**
     * @Route("/form/render/bill_line/{parent}/create", name="path_form_bill_line_create")
     */
    public function billLineCreateAction(Request $request, $parent) {
        $_em = $this->getDoctrine()->getManager();
        
        $bill = $_em->getRepository('UnrtechEasybillBundle:BaseBill')->find($parent);
        $this->get('memcache')->set('current_bill_'.$this->getUser(), $bill, false, 10);
        $object = new BillLine();
        
        $form = $this->createForm(new BillLineType($this->container), $object);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $_em->persist($object);
            $bill->addLine($object);
            $_em->flush();
            
            return $this->redirect($this->generateUrl('path_view_bill', array('id' => $parent)));
        }

        return $this->render('UnrtechEasybillBundle:Form:form_line.html.twig', array(
            'form' => $form->createView(),
            'parent' => $parent,
            'action' => 'create'
        ));
    }

    /**
     * @Route("/form/render/bill_line/{id}-{parent}/edit", name="path_form_bill_line_edit")
     */
    public function billLineEditAction(Request $request, $id, $parent) {
        $_em = $this->getDoctrine()->getManager();
        
        $object = $this->get('memcache')->get('current_bill_'.$this->getUser());
        if (!$object) {
            $object = $_em->getRepository('UnrtechEasybillBundle:BillLine')->find($id);
        } else {
            var_dump($this->get('memcache')->get('current_bill_'.$this->getUser()));
            die();
        }
        
        $form = $this->createForm(new BillLineType($this->container), $object);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $_em->flush();
            
            return $this->redirect($this->generateUrl('path_view_bill', array('id' => $parent)));
        }

        return $this->render('UnrtechEasybillBundle:Form:form_line.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
            'parent' => $parent,
            'action' => 'edit'
        ));
    }
    
    /**
     * @Route("/form/remove/bill_line/{line}", name="path_remove_bill_line")
     * @ParamConverter("line", class="UnrtechEasybillBundle:BillLine")
     */
    public function removeLineAction($line) {
        $_em = $this->getDoctrine()->getManager();
        $billId = $line->getBill()->getId();
        $_em->remove($line);
        $_em->flush();
        
        return $this->redirect($this->generateUrl('path_view_bill', array('id' => $billId)));
    }

}
