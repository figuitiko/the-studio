<?php

namespace App\Controller\Admin;

use App\Entity\LoggerOrder;
use App\Entity\State;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
   
    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
      $this->adminUrlGenerator = $adminUrlGenerator;
    }
   

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // dd(OrderCrudController::class);
        $url = $this->adminUrlGenerator
        ->setController(OrderCrudController::class)
        //->setAction('edit')
        //->setEntityId(1)
        ->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Test Studio');
    }

    public function configureMenuItems(): iterable
    {
        
        yield MenuItem::linktoDashboard('Orders', 'fa fa-home');
        yield MenuItem::linkToCrud('Orders Logger', 'fa fa-history', LoggerOrder::class);
        yield MenuItem::linkToCrud('States', 'fa fa-bell', State::class)->setPermission('ROLE_ADMIN');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
