<?php

namespace App\EventSubscriber;

use App\Entity\HasFileInterface;
use App\Storage\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Event\EntityLifecycleEventInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OnFileAfterEntityPersistedOrUpdatedEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly FileUploader $fileUploader,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterEntityUpdatedEvent::class => 'onAfterPersistOrUpdateEvent',
            AfterEntityPersistedEvent::class => 'onAfterPersistOrUpdateEvent',
        ];
    }

    public function onAfterPersistOrUpdateEvent(EntityLifecycleEventInterface $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof HasFileInterface || !$entity->getFile()->getTransientUploadedFile()) {
            return;
        }

        $this->fileUploader->uploadFile($entity->getFile());
        $this->entityManager->flush();
    }
}
