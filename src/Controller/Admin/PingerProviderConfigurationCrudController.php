<?php

namespace App\Controller\Admin;

use App\Admin\FieldProvider\FieldProviderFinder;
use App\Entity\Configuration\PingerProvider\AbstractPingerProviderConfiguration;
use App\Utils\ClassUtils;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

/** @psalm-suppress PropertyNotSetInConstructor */
class PingerProviderConfigurationCrudController extends AbstractInheritCrudController
{
    public function __construct(
        protected AdminUrlGenerator $adminUrlGenerator,
        protected EntityManagerInterface $entityManager,
        protected readonly FieldProviderFinder $fieldProviderFinder
    ) {
        parent::__construct($this->adminUrlGenerator, $this->entityManager);
    }

    public static function getEntityFqcn(): string
    {
        return AbstractPingerProviderConfiguration::class;
    }

    /** @psalm-suppress MixedArgument */
    protected function getFields(): array
    {
        $context = $this->getContext();

        if ($context?->getEntity()->getInstance() && in_array($context?->getCrud()?->getCurrentAction(), [Action::NEW, Action::EDIT])) {
            $fields = $this->fieldProviderFinder->getFields($context?->getEntity()->getInstance());
        }

        return array_merge($fields ?? [], [
            BooleanField::new('enable', sprintf('%s.enable', ClassUtils::getOnlyClassSnakeCase($this::getEntityFqcn()))),
        ]);
    }
}
