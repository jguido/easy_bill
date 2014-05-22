<?php

namespace Unrtech\Bundle\EasybillBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
}
