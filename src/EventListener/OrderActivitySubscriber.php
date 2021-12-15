<?php

// src/EventListener/DatabaseActivitySubscriber.php
namespace App\EventListener;

use App\Entity\LoggerOrder;
use App\Entity\Order;
use App\Entity\User;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderActivitySubscriber implements EventSubscriberInterface
{
   public $em;
   public $tokenStorage;
   
    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage ){
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        
    }
    
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,           
            Events::postUpdate,
        ];
    }

    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you access
    // to both the entity object of the event and the entity manager itself
    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->logActivity('persist', $args);
    }

   

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->logActivity('update', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // if this subscriber only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof Order) {
            return;
        }
        $state = $entity->getState();
            /* @var User $currentUser */
        $currentUser = $this->tokenStorage->getToken()->getUser();
        if($action === 'persist') {
            
            
            if(!empty($state) && $state->getContent() === 'ORDER_RECEIVED') {
                
                $this->createLoggerOrder($state, $entity, $currentUser, "has been received by the system");
                return;

            }
            return;
        }
        if($action === 'update') {

            if(!empty($state) && $state->getContent() === 'ORDER_CANCELED'){
                $userEmail = $currentUser->getEmail();
                $this->createLoggerOrder($state, $entity, $currentUser, "has been canceled by the $userEmail ");
            }
            if(!empty($state) && $state->getContent() === 'ORDER_PROCESSING'){
                $userEmail = $currentUser->getEmail();
                $this->createLoggerOrder($state, $entity, $currentUser, "has been changed to PROCESSING by $userEmail ");
            }
            if(!empty($state) && $state->getContent() === 'ORDER_READY_TO_SHIP'){
                $userEmail = $currentUser->getEmail();
                $this->createLoggerOrder($state, $entity, $currentUser, "has been changed to READY TO SHIP by $userEmail with BOX_ID: 1213 ");
            }
            
            if(!empty($state) && $state->getContent() === 'ORDER_SHIPPED'){
                $userEmail = $currentUser->getEmail();
                $this->createLoggerOrder($state, $entity, $currentUser, "has been changed to SHIPPED by $userEmail with AWB: #21321313131 by UPS [View Label");
            }
            

        }

        // if($action === 'update'&& $entity->getState() === $entity::PROCESSING_ORDER) {
        //     $loggerOrder = new LoggerOrder();
        //     $loggerOrder->setState($loggerOrder::PROCESSING_ORDER);
        //     $orderId = $entity->getId();
        //     $userId = $this->tokenStorage->getToken()->getUser();
        //     $loggerOrder->setDescription("Order $orderId has been received by the system");
        //     $this->em->persist($loggerOrder);
        //     $this->em->flush();
        //     return;
        // }

        // ... get the entity information and log it somehow
    }
    private function createLoggerOrder($state, $entity, $currentUser, $description){
        $loggerOrder = new LoggerOrder();
                $loggerOrder->setState($state);
                $orderId = $entity->getId();
                $loggerOrder->setDescription("Order $orderId $description");
                $loggerOrder->setOrderToLog($entity);
                $loggerOrder->setUser($currentUser);
                $this->em->persist($loggerOrder);
                $this->em->flush();
    }
    
}