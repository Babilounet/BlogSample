<?php

namespace App\EventSubscriber;

use App\Model\TimestampedInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['setEntityCreatedAt'],
            BeforeEntityUpdatedEvent::class => ['setEntityUpdatedAt']
        ];
    }

    public function setEntityCreatedAt(BeforeEntityPersistedEvent $oEvent): void
    {
        $oEntity = $oEvent->getEntityInstance();

        if (!$oEntity instanceof TimestampedInterface) {
            return;
        }

        $oEntity->setCreatedAt(new \DateTime());
    }

    public function setEntityUpdatedAt(BeforeEntityUpdatedEvent $oEvent): void
    {
        $oEntity = $oEvent->getEntityInstance();

        if (!$oEntity instanceof TimestampedInterface) {
            return;
        }

        $oEntity->setUpdatedAt(new \DateTime());
    }
}