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
use Unrtech\Bundle\EasybillBundle\Entity\Customer;
use Unrtech\Bundle\EasybillBundle\Form\Type\CustomerType;
use Unrtech\Bundle\EasybillBundle\Entity\Company;
use Unrtech\Bundle\EasybillBundle\Form\Type\CompanyType;
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

        $currentUSer = $this->get('security.context')->getToken()->getUser();
        if (!$currentUSer) {
            return $this->renderNotAccessibleResponse($request);
        } else if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\BillUser) {
            if (!$this->get('security.context')->getToken()->getUser()->getCompany()->getBills()->contains($object)) {
                return $this->renderNotAccessibleResponse($request);
            }
        }

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

        $currentUSer = $this->get('security.context')->getToken()->getUser();
        if (!$currentUSer) {
            return $this->renderNotAccessibleResponse($request);
        } else if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\BillUser) {
            if (!$this->get('security.context')->getToken()->getUser()->getCompany()->getBills()->contains($bill)) {
                return $this->renderNotAccessibleResponse($request);
            }
        }

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

        $object = $_em->getRepository('UnrtechEasybillBundle:BillLine')->find($id);

return $this->renderNotAccessibleResponse($request);
        $currentUSer = $this->get('security.context')->getToken()->getUser();
        if (!$currentUSer) {
            return $this->renderNotAccessibleResponse($request);
        } else if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\BillUser) {
            if (!$currentUSer->getCompany()->getBills()->contains($object->getBill())) {
                return $this->renderNotAccessibleResponse($request);
            }
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

        $currentUSer = $this->get('security.context')->getToken()->getUser();
        if (!$currentUSer) {
            return $this->renderNotAccessibleResponse($request);
        } else if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\BillUser) {
            if (!$this->get('security.context')->getToken()->getUser()->getCompany()->getBills()->contains($line->getBill())) {
                return $this->renderNotAccessibleResponse($request);
            }
        }

        $billId = $line->getBill()->getId();
        $_em->remove($line);
        $_em->flush();

        return $this->redirect($this->generateUrl('path_view_bill', array('id' => $billId)));
    }

    /**
     * @Route("/form/render/customer/create", name="path_form_customer_create")
     */
    public function createCustomerAction(Request $request) {
        $_em = $this->getDoctrine()->getManager();

        $object = new Customer();

        $form = $this->createForm(new CustomerType($this->container), $object);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $_em->persist($object);
            $_em->flush();

            return $this->redirect($this->generateUrl('path_customers'));
        }

        return $this->render('UnrtechEasybillBundle:Form:form_customer.html.twig', array(
                    'form' => $form->createView(),
                    'action' => 'create'
        ));
    }

    /**
     * @Route("/form/render/customer/edit/{id}", name="path_form_customer_edit")
     */
    public function editCustomerAction(Request $request, $id) {
        $_em = $this->getDoctrine()->getManager();

        $object = $_em->getRepository('UnrtechEasybillBundle:Customer')->find($id);


        $currentUSer = $this->get('security.context')->getToken()->getUser();
        if (!$currentUSer) {
            return $this->renderNotAccessibleResponse($request);
        } else if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\BillUser) {
            if (!$this->get('security.context')->getToken()->getUser()->getCompany()->getCustomers()->contains($object)) {
                return $this->renderNotAccessibleResponse($request);
            }
        }

        $form = $this->createForm(new CustomerType($this->container), $object);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $_em->flush();

            return $this->redirect($this->generateUrl('path_customers'));
        }

        return $this->render('UnrtechEasybillBundle:Form:form_customer.html.twig', array(
                    'form' => $form->createView(),
                    'id' => $id,
                    'action' => 'edit'
        ));
    }

    /**
     * @Route("/form/render/company/create", name="path_form_company_create")
     */
    public function createCompanyAction(Request $request) {
        $_em = $this->getDoctrine()->getManager();

        $object = new Company();

        $form = $this->createForm(new CompanyType($this->container), $object);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $_em->persist($object);
            $_em->flush();

            return $this->redirect($this->generateUrl('path_parameters'));
        }

        return $this->render('UnrtechEasybillBundle:Form:form_company.html.twig', array(
                    'form' => $form->createView(),
                    'action' => 'create'
        ));
    }

    /**
     * @Route("/form/render/company/edit/{id}", name="path_form_company_edit")
     */
    public function editCompanyAction(Request $request, $id) {
        $_em = $this->getDoctrine()->getManager();

        $object = $_em->getRepository('UnrtechEasybillBundle:Company')->find($id);

        $currentUSer = $this->get('security.context')->getToken()->getUser();
        if (!$currentUSer) {
            return $this->renderNotAccessibleResponse($request);
        } else if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\BillUser) {
            if (!$this->get('security.context')->getToken()->getUser()->getCompany() === $object) {
                return $this->renderNotAccessibleResponse($request);
            }
        }

        $form = $this->createForm(new CompanyType($this->container), $object);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $_em->flush();

            return $this->redirect($this->generateUrl('path_parameters'));
        }

        return $this->render('UnrtechEasybillBundle:Form:form_company.html.twig', array(
                    'form' => $form->createView(),
                    'id' => $id,
                    'action' => 'edit'
        ));
    }

    private function renderNotAccessibleResponse(Request $request) {
        if ($request->isXmlHttpRequest()) {
            return new Response(null, 403);
        } else {
            return $this->redirect($this->generateUrl('fos_user_security_logout'));
        }
    }

}
