<?php

namespace App\Controller\Admin;

use App\Entity\Configuration\AllChildOnSameCrudControllerInterface;
use App\Utils\ActionNameGuesser;
use App\Utils\ClassUtils;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Translation\TranslatableMessage;

/** @psalm-suppress PropertyNotSetInConstructor */
abstract class AbstractInheritCrudController extends AbstractCrudController
{
    private ?ClassMetadata $classMetadata = null;

    public function __construct(
        protected AdminUrlGenerator $adminUrlGenerator,
        protected EntityManagerInterface $entityManager
    ) {
    }

    /** @psalm-suppress MissingReturnType */
    public function createEntity(string $entityFqcn)
    {
        if (!($subClassname = $this->getContext()?->getRequest()->query->get('sub_class')) || !is_string($subClassname)) {
            throw new \LogicException('Impossible de trouver la sous-classe');
        }

        if (!class_exists($subClassname)) {
            throw new \LogicException(sprintf('La classe "%s" n\'existe pas', $subClassname));
        }

        /** @psalm-suppress MixedMethodCall */
        return new $subClassname();
    }

    protected function getClassMetadata(): ClassMetadata
    {
        return $this->classMetadata ?? $this->classMetadata = $this->entityManager->getClassMetadata($this::getEntityFqcn());
    }

    protected function validateAbstractParent(): void
    {
        if (!$this->getClassMetadata()->reflClass?->implementsInterface(AllChildOnSameCrudControllerInterface::class)) {
            throw new \LogicException(sprintf('La classe %s doit implémenter l\'interface %s', $this::getEntityFqcn(), AllChildOnSameCrudControllerInterface::class));
        }
    }

    /** @return string[] */
    protected function getChildClassnames(): array
    {
        $this->validateAbstractParent();

        return $this->getClassMetadata()->subClasses;
    }

    public function configureActions(Actions $actions): Actions
    {
        foreach ($this->getChildClassnames() as $childClassname) {
            $this->addNewActionOnIndexForChild($actions, $childClassname, sprintf('%s.add_new.%s', ClassUtils::getOnlyClassSnakeCase($this::getEntityFqcn()), ClassUtils::getOnlyClassSnakeCase($childClassname)));
        }

        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
        ;
    }

    protected function addNewActionOnIndexForChild(Actions $actions, string $childClassname, string $label): void
    {
        $actions
            ->add(Crud::PAGE_INDEX, Action::new(ActionNameGuesser::guessActionName('add_new_', $childClassname), $label)->linkToUrl(
                $this->adminUrlGenerator
                    ->setController($this::class)
                    ->setAction(Action::NEW)
                    ->set('sub_class', $childClassname)
                    ->generateUrl()
            )->createAsGlobalAction())
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, sprintf('%s.title', ClassUtils::getOnlyClassSnakeCase($this::getEntityFqcn())))
            ->setPageTitle(Crud::PAGE_EDIT, function (AllChildOnSameCrudControllerInterface $allChildOnSameCrudController) {
                return new TranslatableMessage(sprintf('edit_%s', ClassUtils::getOnlyClassSnakeCase(get_class($allChildOnSameCrudController))), ['%id%' => $allChildOnSameCrudController->getId()]);
            })
            ->showEntityActionsInlined()
        ;
    }

    /**
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function configureFields(string $pageName): iterable
    {
        return array_merge([
            TextField::new('getAdminListName', sprintf('%s.type', ClassUtils::getOnlyClassSnakeCase($this::getEntityFqcn())))->onlyOnIndex(),
        ], $this->getFields());
    }

    abstract protected function getFields(): array;
}
