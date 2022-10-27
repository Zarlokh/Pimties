<?php

namespace App\Controller\Admin;

use App\Entity\Configuration\NewProductConfiguration;
use App\Entity\Configuration\SecondHandProductConfiguration;
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
        yield MenuItem::linkToCrud('Configuration produit d\'occasion', 'fa-solid fa-file-invoice-dollar', SecondHandProductConfiguration::class);
        yield MenuItem::linkToCrud('Configuration produit neuf', 'fa-solid fa-file-invoice-dollar', NewProductConfiguration::class);
        yield MenuItem::linkToCrud('Garanties', 'fa-solid fa-file-invoice-dollar', Warranty::class);
    }
}
