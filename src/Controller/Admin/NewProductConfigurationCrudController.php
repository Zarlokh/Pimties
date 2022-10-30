<?php

namespace App\Controller\Admin;

use App\Entity\Configuration\Product\NewProductConfiguration;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class NewProductConfigurationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NewProductConfiguration::class;
    }
}
