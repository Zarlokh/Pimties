<?php

namespace App\Controller\Admin;

use App\Entity\Warranty;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'Ajouter une facture')
            ->setPageTitle('index', 'Liste des factures')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            DateField::new('startDate', 'Date d\'achat')->setFormTypeOption('input', 'datetime_immutable'),
            DateField::new('endDate', 'Date de fin de garantie')->hideOnForm(),
            NumberField::new('warrantyTime', 'Temps de garantie')->setRequired(false),
            BooleanField::new('isSecondHandProduct', 'Produit d\'occasion ?')
        ];
    }
}
