<?php

namespace App\Controller\Admin;

use App\Entity\Configuration\PingerProvider\AbstractPingerProviderConfiguration;
use App\Entity\Configuration\Product\AbstractProductConfiguration;
use App\Entity\Configuration\StorageProvider\AbstractStorageProviderConfiguration;
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
        yield MenuItem::linkToDashboard('menu.home', 'fa fa-home');
        yield MenuItem::section('menu.section.configuration', 'fa-solid fa-gears');
        yield MenuItem::linkToCrud('menu.configuration.product_configuration', '', AbstractProductConfiguration::class);
        yield MenuItem::linkToCrud('menu.configuration.pinger_provider', '', AbstractPingerProviderConfiguration::class);
        yield MenuItem::linkToCrud('menu.configuration.storage_provider', '', AbstractStorageProviderConfiguration::class);
        yield MenuItem::section('menu.section.bill', 'fa-solid fa-file-invoice-dollar');
        yield MenuItem::linkToCrud('menu.bill.bill', '', Warranty::class);
    }
}
