<?php

namespace App\Controller\Admin;

use App\Entity\Configuration\PingerProvider\AbstractPingerProviderConfiguration;
use App\Entity\Configuration\Product\AbstractProductConfiguration;
use App\Entity\Warranty;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/admin_layout.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Pimties');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::section('menu_section_configuration', 'fa-solid fa-gears');
        yield MenuItem::linkToCrud('Configuration de produit', '', AbstractProductConfiguration::class);
        yield MenuItem::linkToCrud('Configuration de pinger', '', AbstractPingerProviderConfiguration::class);
        yield MenuItem::section('menu_section_bill', 'fa-solid fa-file-invoice-dollar');
        yield MenuItem::linkToCrud('Factures', '', Warranty::class);
    }
}
