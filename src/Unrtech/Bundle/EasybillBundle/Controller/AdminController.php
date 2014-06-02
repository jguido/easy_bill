<?php

namespace Unrtech\Bundle\EasybillBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller {

    /**
     * @Route("/bill/admin", name="path_administration")
     */
    public function administrationAction(Request $request) {
        $currentUSer = $this->get('security.context')->getToken()->getUser();
        if (!$currentUSer) {
            return $this->renderNotAccessibleResponse($request);
        } else if (!$currentUSer instanceof \Unrtech\Bundle\EasybillBundle\Entity\SuperAdmin) {
            return $this->renderNotAccessibleResponse($request);
        }
        
    }
    
    private function renderNotAccessibleResponse(Request $request) {
        if ($request->isXmlHttpRequest()) {
            return new Response(null, 403);
        } else {
            return $this->redirect($this->generateUrl('fos_user_security_logout'));
        }
    }

}
