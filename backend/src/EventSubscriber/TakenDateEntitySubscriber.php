<?php

namespace App\EventSubscriber;

use App\Entity\Note;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TakenDateEntitySubscriber implements EventSubscriberInterface {
    public static function getSubscribedEvents() {
        return [
            KernelEvents::VIEW => ['setDateTaken', EventPriorities::PRE_WRITE]
        ];
    }

    public function setDateTaken(ViewEvent $event) {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof Note || Request::METHOD_POST !== $method) {
            return;
        }

        $entity->setTaken(new \DateTime());
    }
}