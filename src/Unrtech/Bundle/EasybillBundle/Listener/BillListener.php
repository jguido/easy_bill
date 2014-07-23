<?php

namespace Unrtech\Bundle\EasybillBundle\Listener;

use Unrtech\Bundle\EasybillBundle\Entity\BaseBill;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of BillListener
 *
 * @author jeremy
 */
class BillListener {
    protected $_container;
    
    public function setContainer(ContainerInterface $container) {
        $this->_container = $container;
    }
    
    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $_em = $args->getEntityManager();
        if (null !== $this->_container->get('security.context')) {
            $token = $this->_container->get('security.context')->getToken();
            if ($token) {
                $company = $this->_container
                        ->get('doctrine.orm.default_entity_manager')
                        ->createQuery(
                                'SELECT c
                                FROM UnrtechEasybillBundle:Company c
                                JOIN UnrtechEasybillBundle:BillUser b
                                WHERE b.id  = :id'
                        )
                        ->setParameter(':id', $token->getUser()->getId())
                        ->execute();
                
//                $company = $token->getUser()->getCompany();
                if (!$token->getUser() instanceof \Unrtech\Bundle\EasybillBundle\Entity\SuperAdmin) {
                    if ($entity instanceof BaseBill) {
                        try {
                            $entity->setCompany($company[0]);
                        } catch (\Exception $e) {
                            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException($e->getMessage(), $e->getCode());
                        }
                    }
                }
            }
        }
        
        return $entity;
    }
    
    public function preUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $_em = $args->getEntityManager();
        $uow = $_em->getUnitOfWork();
        if (null !== $this->_container->get('security.context')) {
            $token = $this->_container->get('security.context')->getToken();
            if ($token) {
                if (!$token->getUser() instanceof \Unrtech\Bundle\EasybillBundle\Entity\SuperAdmin) {
//                    $company = $token->getUser()->getCompany();
                    $company = $this->_container
                        ->get('doctrine.orm.default_entity_manager')
                        ->createQuery(
                                'SELECT c
                                FROM UnrtechEasybillBundle:Company c
                                JOIN UnrtechEasybillBundle:BillUser b
                                WHERE b.id  = :id'
                        )
                        ->setParameter(':id', $token->getUser()->getId())
                        ->execute();
                    if ($entity instanceof BaseBill) {
                        try {
                            $entity->setCompany($company[0]);
                            $uow->recomputeSingleEntityChangeSet($_em->getClassMetadata('UnrtechEasybillBundle:BaseBill'), $entity);
                        } catch (\Exception $e) {
                            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException($e->getMessage(), $e->getCode());
                        }

                    }
                }
            }
        }
        
        return $entity;
    }
}
