<?php

namespace CourseBundle\Listener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DoctrineListener {
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    
    public function __construct(EventDispatcherInterface $eventDispatcher) {
        $this->eventDispatcher = $eventDispatcher;
    }
    
   
   public function prePersist(LifecycleEventArgs $args) {
       $entity = $args->getEntity();
       
       
       $this->eventDispatcher->dispatch('book.new');
   }
}
