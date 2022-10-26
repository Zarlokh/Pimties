<?php

namespace App\Controller\Admin;

use App\Entity\Warranty;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class WarrantyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Warranty::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
