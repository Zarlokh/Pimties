<?php

namespace App\Controller\Admin;

use App\Entity\Configuration\Product\AbstractProductConfiguration;
use App\Entity\Configuration\Product\NewProductConfiguration;
use App\Entity\Configuration\Product\SecondHandProductConfiguration;
use App\Repository\Configuration\Product\NewProductConfigurationRepository;
use App\Repository\Configuration\Product\SecondHandProductConfigurationRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

/** @psalm-suppress PropertyNotSetInConstructor */
class ProductConfigurationCrudController extends AbstractCrudController
{
    public function __construct(
        protected readonly AdminUrlGenerator $adminUrlGenerator,
        protected readonly NewProductConfigurationRepository $newProductConfigurationRepository,
        protected readonly SecondHandProductConfigurationRepository $secondHandProductConfigurationRepository
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return AbstractProductConfiguration::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Configuration des produits')
            ->setPageTitle(Crud::PAGE_EDIT, function (AbstractProductConfiguration $abstractProductConfiguration) {
                return sprintf('Edition de la configuration "%s" @id=%d', $abstractProductConfiguration->getAdminListName(), $abstractProductConfiguration->getId() ?? -1);
            })
            ->showEntityActionsInlined()
        ;
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_INDEX, Action::new('add_new_product_configuration', 'Ajouter une configuration de produit neuf')->linkToUrl(
                $this->adminUrlGenerator
                    ->setController(self::class)
                    ->setAction(Action::NEW)
                    ->set('sub_class', NewProductConfiguration::class)
                    ->generateUrl()
            )->createAsGlobalAction())
            ->add(Crud::PAGE_INDEX, Action::new('add_second_hand_product_configuration', 'Ajouter une configuration de produit d\'occasion')->linkToUrl(
                $this->adminUrlGenerator
                    ->setController(self::class)
                    ->setAction(Action::NEW)
                    ->set('sub_class', SecondHandProductConfiguration::class)
                    ->generateUrl()
            )->createAsGlobalAction()->createAsGlobalAction())
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('getAdminListName', 'Type de configuration')->onlyOnIndex(),
            NumberField::new('warrantyTime', 'Temps de garantie par défaut'),
        ];
    }
}
