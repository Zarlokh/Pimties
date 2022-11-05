<?php

namespace App\EventSubscriber;

use App\Entity\Configuration\Product\AbstractProductConfiguration;
use App\Repository\Configuration\Product\AbstractProductConfigurationRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class OnBeforeProductConfigurationEvent implements EventSubscriberInterface
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
        protected readonly AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeCrudActionEvent::class => 'onBeforeNewProductConfiguration',
        ];
    }

    public function onBeforeNewProductConfiguration(BeforeCrudActionEvent $event): void
    {
        $adminContext = $event->getAdminContext();
        if (!$adminContext || $adminContext->getEntity()->getFqcn() !== AbstractProductConfiguration::class || Action::NEW !== $adminContext->getCrud()?->getCurrentAction()) {
            return;
        }
        $subclass = $adminContext->getRequest()->query->get('sub_class');

        if (!is_string($subclass) || !class_exists($subclass)) {
            return;
        }
        /** @var AbstractProductConfigurationRepository $repo */
        $repo = $this->entityManager->getRepository($subclass);
        $session = $adminContext->getRequest()->getSession();
        $currentController = $event->getAdminContext()?->getCrud()->getControllerFqcn();

        if (!$repo->hasConfiguration() || !method_exists($session, 'getFlashBag') || !($flashBag = $session->getFlashBag()) instanceof FlashBagInterface || !$currentController) {
            return;
        }

        $flashBag->add('danger', 'Une configuration existe déjà');

        $event->setResponse(new RedirectResponse(
            $this->adminUrlGenerator
                ->setAction(Action::INDEX)
                ->setController($currentController)
                ->generateUrl()
        ));
    }
}
