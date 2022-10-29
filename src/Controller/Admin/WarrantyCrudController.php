<?php

namespace App\Controller\Admin;

use App\Admin\Field\ToggleHideOtherFieldsField;
use App\Entity\Warranty;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WarrantyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Warranty::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter une facture');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Créer');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Créer et ajouter un autre');
            })
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setDefaultSort([
                'endDate' => 'ASC'
            ])
            ->setPageTitle('new', 'Ajouter une facture')
            ->setPageTitle('index', 'Liste des factures')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $warrantyTimeField = NumberField::new('extendedWarrantyTime', 'Temps de garantie')
            ->setRequired(false)
            ->hideOnIndex()
        ;

        $hasExtendedWarrantyTime = ToggleHideOtherFieldsField::new('hasExtendedWarrantyTime', 'Définir manuellement une durée de garantie')
            ->addFieldsToToggleHide([$warrantyTimeField], [$warrantyTimeField])
            ->onlyOnForms()
        ;

        return [
            TextField::new('name', 'Nom'),
            DateField::new('startDate', 'Date d\'achat')->setFormTypeOption('input', 'datetime_immutable'),
            DateField::new('endDate', 'Date de fin de garantie')->hideOnForm(),
            NumberField::new('calculateWarrantyTime', 'Temps de garantie')->onlyOnIndex()->formatValue(fn (int $warrantyTime) => "$warrantyTime an(s)"),
            BooleanField::new('isSecondHandProduct', 'Produit d\'occasion ?'),
            $hasExtendedWarrantyTime,
            $warrantyTimeField,
        ];
    }
}
