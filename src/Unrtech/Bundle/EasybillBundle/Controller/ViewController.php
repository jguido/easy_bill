<?php

namespace Unrtech\Bundle\EasybillBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Unrtech\Bundle\EasybillBundle\Entity\SuperAdmin;
use Unrtech\Bundle\EasybillBundle\Entity\BillUser;

class ViewController extends Controller
{
    protected $_cache;


//    public function __construct() {
//        $this->_cache = new Memcache();
//        $this->_cache->connect('localhost', 11211) or die("Connexion impossible");
//    }
    /**
     * @Route("/", name="path_home")
     */
    public function homeAction()
    {
        $check = $this->checkIfUSerHasCompany($this->get('security.context')->getToken());
        if ($check !== true) {
            return $check;
        }
        
        return $this->render('UnrtechEasybillBundle:Default:home.html.twig', array('title' => 'EasyBill'));
    }
    
    /**
     * @Route("/bills", name="path_bills")
     */
    public function billsAction()
    {
        $currentUSer = $this->get('security.context')->getToken()->getUser();
        if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\SuperAdmin) {
            $entities = $this->getDoctrine()->getManager()->getRepository('UnrtechEasybillBundle:BaseBill')->findAll();
        } else if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\BillUser) {
            $entities = $this->get('security.context')->getToken()->getUser()->getCompany()->getBills();
        } else {
            $this->redirect($this->generateUrl('fos_user_security_logout'));
        }
        
        return $this->render('UnrtechEasybillBundle:Bill:bills.html.twig', array('bills' => $entities));
    }
    
    /**
     * @Route("/customers", name="path_customers")
     */
    public function customersAction()
    {
        $currentUSer = $this->get('security.context')->getToken()->getUser();
        if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\SuperAdmin) {
            $entities = $this->getDoctrine()->getManager()->getRepository('UnrtechEasybillBundle:Customer')->findAll();
        } else if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\BillUser) {
            $entities = $this->get('security.context')->getToken()->getUser()->getCompany()->getCustomers();
        } else {
            return $this->redirect($this->generateUrl('fos_user_security_logout'));
        }
        
        return $this->render('UnrtechEasybillBundle:Customer:customers.html.twig', array('customers' => $entities));
    }
    
    /**
     * @Route("/bill/{id}", name="path_view_bill")
     */
    public function viewAction($id) {
        $currentUSer = $this->get('security.context')->getToken()->getUser();
        $entity = $this->getDoctrine()->getManager()->getRepository('UnrtechEasybillBundle:BaseBill')->find($id);
        if (!$currentUSer) {
            return $this->redirect($this->generateUrl('fos_user_security_logout'));
        } else if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\BillUser) {
            if (!$this->get('security.context')->getToken()->getUser()->getCompany()->getBills()->contains($entity)) {
                return $this->redirect($this->generateUrl('fos_user_security_logout'));
            }
        }
        
        return $this->render('UnrtechEasybillBundle:Bill:bill_view.html.twig', array('bill' => $entity));
    }
    /**
     * @Method({"POST"})
     * @Route("/bill/line/rank", name="path_change_rank_bill_line")
     */
    public function changeRankController() {
        $_em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $postData = $request->request->get('data');
        $id = $request->request->get('id');
        
        $object = $_em->getRepository('UnrtechEasybillBundle:BillLine')->find($id);
        
        if (!$object) {
            return $this->render('UnrtechEasybillBundle::404.html.twig');
        }
        $entity = $object->getBill();
        
        $currentUSer = $this->get('security.context')->getToken()->getUser();
        if (!$currentUSer) {
            return $this->redirect($this->generateUrl('fos_user_security_logout'));
        } else if ($currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\BillUser) {
            if (!$this->get('security.context')->getToken()->getUser()->getCompany()->getBills()->contains($entity)) {
                return $this->redirect($this->generateUrl('fos_user_security_logout'));
            }
        }
        
        if (count($entity->getLines()) <= 0) {
            return $this->render('UnrtechEasybillBundle::404.html.twig');
        }
        
        if (count($postData) <= 0) {
            return $this->render('UnrtechEasybillBundle::404.html.twig');
            
        }
        foreach ($entity->getLines() as $line) {
            foreach ($postData as $data) {
                if (intval($data['id']) === $line->getId()) {
                    $line->setRank($data['rank']);
                }
            }
        }
        $_em->flush();
        
        return new \Symfony\Component\HttpFoundation\Response('', 200);
    }
    
    private function checkIfUSerHasCompany($token) {
        if ($token) {
            $currentUser = $token->getUser();
            if ($currentUser instanceof BillUser && !$currentUser->getCompany() || !$currentUser instanceof SuperAdmin) {
                
//                return $this->redirect($this->generateUrl('path_form_company_create'));
            }
        }
        
        return true;
    }
}
