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
                $company = $token->getUser()->getCompany();
                if (!$token->getUser() instanceof Unrtech\Bundle\EasybillBundle\Entity\SuperAdmin) {
                    if ($entity instanceof BaseBill) {
                        try {
                            $entity->setCompany($company);
                        } catch (\Exception $e) {
                            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException($e->getMessage(), $e->getCode());
                        }
                    }
                }
            }
        }
    }
    
    public function preUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $_em = $args->getEntityManager();
        $uow = $_em->getUnitOfWork();
        if (null !== $this->_container->get('security.context')) {
            $token = $this->_container->get('security.context')->getToken();
            if ($token) {
                if (!$token->getUser() instanceof Unrtech\Bundle\EasybillBundle\Entity\SuperAdmin) {
                    $company = $token->getUser()->getCompany();
                    if ($entity instanceof BaseBill) {
                        try {
                            $entity->setCompany($company);
                            $uow->recomputeSingleEntityChangeSet($_em->getClassMetadata('UnrtechEasybillBundle:BaseBill'), $entity);
                        } catch (\Exception $e) {
                            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException($e->getMessage(), $e->getCode());
                        }

                    }
                }
            }
        }
    }
}
