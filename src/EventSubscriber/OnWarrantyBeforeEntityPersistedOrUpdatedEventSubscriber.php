<?php

namespace App\EventSubscriber;

use App\Entity\Warranty;
use App\Warranty\WarrantyCalculatedValuesUpdaterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Event\EntityLifecycleEventInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OnWarrantyBeforeEntityPersistedOrUpdatedEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly WarrantyCalculatedValuesUpdaterInterface $warrantyEndDateUpdater)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => 'onBeforePersistOrUpdateEvent',
            BeforeEntityPersistedEvent::class => 'onBeforePersistOrUpdateEvent'
        ];
    }

    public function onBeforePersistOrUpdateEvent(EntityLifecycleEventInterface $event): void
    {
        $entity = $event->getEntityInstance();
        if (! $entity instanceof Warranty) {
            return;
        }
        $this->warrantyEndDateUpdater->update($entity);
    }
}
