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

class ParamController extends Controller {

    /**
     * @Route("/form/param/company/create", name="path_form_company_create")
     */
    public function companyCreateAction(Request $request) {
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

}
