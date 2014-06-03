<?php

namespace Unrtech\Bundle\EasybillBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
        
        $source = new Entity('UnrtechEasybillBundle:BillUser');
        
        $grid = $this->get('grid');
        $grid->setSource($source);
        
        $rowEdit = new RowAction('', 'path_admin_user_edit', false, '_self', array('class' => 'btn btn-primary glyphicon glyphicon-pencil'), 'ROLE_SUPER_ADMIN');
        $rowEdit->setRouteParameters(array('id'));
        $grid->addRowAction($rowEdit);
        
        $rowDelete = new RowAction('', 'path_admin_user_delete', true, '_self', array('class' => 'btn btn-warning  glyphicon glyphicon-trash'), 'ROLE_SUPER_ADMIN');
        $rowDelete->setConfirmMessage('Etes vous sûr de vouloir supprimer cet utilisateurs?');
        $rowDelete->setRouteParameters(array('id'));
        $grid->addRowAction($rowDelete);
        
        $grid->setLimits(50);
        
        return $grid->getGridResponse('UnrtechEasybillBundle:Grid:admin_users.html.twig');
    }
    
    /**
     * @Route("/bill/admin/user/edit/{id}", name="path_admin_user_edit")
     */
    public function editUserAction($id) {
        
    }
    
    /**
     * @Route("/bill/admin/user/delete/{id}", name="path_admin_user_delete")
     */
    public function deleteUserAction($id) {
        
    }
    
    private function renderNotAccessibleResponse(Request $request) {
        if ($request->isXmlHttpRequest()) {
            return new Response(null, 403);
        } else {
            return $this->redirect($this->generateUrl('fos_user_security_logout'));
        }
    }

}
