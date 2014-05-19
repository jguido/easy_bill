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
        $entities = $this->getDoctrine()->getManager()->getRepository('UnrtechEasybillBundle:BaseBill')->findAll();
        
        return $this->render('UnrtechEasybillBundle:Bill:bills.html.twig', array('bills' => $entities));
    }
    
    /**
     * @Route("/bill/{id}", name="path_view_bill")
     */
    public function viewAction($id) {
        $entity = $this->getDoctrine()->getManager()->getRepository('UnrtechEasybillBundle:BaseBill')->find($id);
        
        return $this->render('UnrtechEasybillBundle:Bill:bill_view.html.twig', array('bill' => $entity));
    }
}
