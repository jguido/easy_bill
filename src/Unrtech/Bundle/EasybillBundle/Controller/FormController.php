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
     * @Route("/form/render/bill/{id}", name="path_form_bill")
     */
    public function billAction(Request $request, $id = null) {
        $_em = $this->getDoctrine()->getManager();
        $object = $id ? $_em->getRepository('UnrtechEasybillBundle:BaseBill')->find($id) : new BaseBill();
        
        $form = $this->createForm(new BillType($this->container), $object);
        
//        $form->handleRequest($request);
        $form->submit($request->get('bill'));
        if ($form->isValid()) {
            if (null === $object->getId()) {
                $_em->persist($object);
            }
            
            $_em->flush();
            $bill = $_em->getRepository('UnrtechEasybillBundle:BaseBill')->findOneBy(array('slug' => $object->getSlug()));
            return $this->redirect($this->generateUrl('path_view_bill', array(
                'id' => $bill->getId()
            )));
        }

        return $this->render('UnrtechEasybillBundle:Form:form_bill.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/form/render/bill_line/{id}-{parent}", name="path_form_bill_line")
     */
    public function billLineAction(Request $request, $parent, $id = null) {
        $_em = $this->getDoctrine()->getManager();
        
        if ($id) { 
            $object = $_em->getRepository('UnrtechEasybillBundle:BillLine')->find($id);
        } else {
            $object = new BillLine();
            $object->setBill($_em->getRepository('UnrtechEasybillBundle:BaseBill')->find($parent));
        }
        
        $form = $this->createForm(new BillLineType($this->container), $object);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            if (null === $object->getId()) {
                $_em->persist($object);
            }
            
            $_em->flush();
            
            return $this->redirect($this->generateUrl('path_view_bill', array('id' => $parent)));
        }

        $form->handleRequest($request);
        $formHanlder = new FormHandler($form, $request, $this->container);

        $processData = $formHanlder->process();
        
        if ($processData) {
            
            return $this->redirect($this->generateUrl('path_view_bill', array('id' => $processData->getBill()->getId())));
        }

        return $this->render('UnrtechEasybillBundle:Form:form_line.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
            'parent' => $parent
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
