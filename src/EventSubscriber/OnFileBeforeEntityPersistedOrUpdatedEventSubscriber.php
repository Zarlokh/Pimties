<?php

namespace App\EventSubscriber;

use App\Entity\HasFileInterface;
use App\Storage\FileUploader;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Event\EntityLifecycleEventInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OnFileBeforeEntityPersistedOrUpdatedEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly FileUploader $fileUploader
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => 'onBeforePersistOrUpdateEvent',
            BeforeEntityPersistedEvent::class => 'onBeforePersistOrUpdateEvent',
        ];
    }

    public function onBeforePersistOrUpdateEvent(EntityLifecycleEventInterface $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof HasFileInterface) {
            return;
        }

        $this->fileUploader->uploadFile($entity->getFile());
    }
}
