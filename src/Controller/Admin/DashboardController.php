<?php

namespace App\Controller\Admin;

use App\Entity\Configuration\Product\NewProductConfiguration;
use App\Entity\Configuration\Product\SecondHandProductConfiguration;
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
        yield MenuItem::section('Configuration', 'fa-solid fa-gears');
        yield MenuItem::linkToCrud('Produit d\'occasion', '', SecondHandProductConfiguration::class);
        yield MenuItem::linkToCrud('Produit neuf', '', NewProductConfiguration::class);
        yield MenuItem::section('Factures', 'fa-solid fa-file-invoice-dollar');
        yield MenuItem::linkToCrud('Factures', '', Warranty::class);
    }
}
