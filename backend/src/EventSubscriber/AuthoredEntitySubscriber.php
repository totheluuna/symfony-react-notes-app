<?php

namespace App\EventSubscriber;

use App\Entity\Note;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthoredEntitySubscriber implements EventSubscriberInterface {
    public function __construct(TokenStorageInterface $tokenStorage) {
        $this->tokenStorage = $tokenStorage;
    }
    public static function getSubscribedEvents() {
        return [
            KernelEvents::VIEW => ['getAuthenticatedUser', EventPriorities::PRE_WRITE]
        ];
    }

    public function getAuthenticatedUser(ViewEvent $event) {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        /** @var UserInterface $author */
        $author = $this->tokenStorage->getToken()->getUser();

        if (!$entity instanceof Note || Request::METHOD_POST !== $method) {
            return;
        }

        $entity->setUser($author);
    }
}