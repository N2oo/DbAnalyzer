<?php

namespace App\Controller\Admin;

use App\Entity\Table;
use App\Entity\Column;
use App\Entity\DbUser;
use App\Entity\DependOn;
use App\Entity\Detail;
use App\Entity\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    )
    {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DbAnalyzer');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Retour à l\'app', 'fa fa-home',$this->urlGenerator->generate("app_main"));
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Tables', 'fas fa-list', Table::class);
        yield MenuItem::linkToCrud('Colonnes', 'fas fa-list', Column::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', DbUser::class);
        yield MenuItem::linkToCrud('Dépendance', 'fas fa-list', DependOn::class);
        yield MenuItem::linkToCrud('Détail', 'fas fa-list', Detail::class);
        yield MenuItem::linkToCrud('Vues', 'fas fa-list', View::class);
    }
}
