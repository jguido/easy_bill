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
        
        $form = $this->get('form.factory')->create(new BillType($this->container));

        $object = $id ? $this->getDoctrine()->getManager()->getRepository('UnrtechEasybillBundle:BaseBill')->find($id) : new BaseBill();
        if ($object) {
            $form->setData($object);
        }
        $formHanlder = new FormHandler($form, $request, $this->container);

        $bill = $formHanlder->process();
        
        if ($bill) {
            
            return $this->render('UnrtechEasybillBundle:Bill:Bill.html.twig', array(
                'bill' => $bill
            ));
        }

        return $this->render('UnrtechEasybillBundle:Form:form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/form/render/bill_line/{id}", name="path_form_bill_line")
     */
    public function billLineAction(Request $request, $id = null) {

        $form = $this->get('form.factory')->create(new BillLineType($this->container));

        $object = $id ? $this->getDoctrine()->getManager()->getRepository('UnrtechEasybillBundle:BillLine')->find($id) : new BillLine();
        if ($object) {
            $form->setData($object);
        }
        $formHanlder = new FormHandler($form, $request, $this->container);

        if ($formHanlder->process()) {
            $this->get('session')->getFlashBag()->add('success', 'success');
        }

        return $this->render('UnrtechEasybillBundle:Form:form.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/form/remove/bill_line/{line}", name="path_remove_bill_line")
     * @ParamConverter("line", class="UnrtechEasybillBundle:BillLine")
     */
    public function removeLineAction($line) {
        
        return new Response($this->getDoctrine()->getManager()->remove($line));
    }

}
