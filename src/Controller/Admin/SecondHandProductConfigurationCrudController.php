<?php

namespace App\Controller\Admin;

use App\Entity\Configuration\SecondHandProductConfiguration;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SecondHandProductConfigurationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SecondHandProductConfiguration::class;
    }
}
