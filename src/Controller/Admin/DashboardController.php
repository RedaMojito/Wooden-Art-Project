<?php

namespace App\Controller\Admin;



use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
       
       $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
      //return parent::index();
      return $this->redirect($routeBuilder->setController(ArticleCrudController::class)->generateUrl());
    }
    /**
     * @Route("/user", name="user")
     */
    public function userSection(): Response
    {
       
       $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
      //return parent::index();
      return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Wooden Art');
    }

    public function configureMenuItems(): iterable
    {
           yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
         //  yield MenuItem::linkToDashboard('Users', 'fas fa-user-friends');
         yield MenuItem::linkToCrud('Articles', 'far fa-newspaper', Article::class)
            ->setController(ArticleCrudController::class);
          yield MenuItem::linkToCrud('Users', 'fas fa-user-friends', User::class)
            ->setController(UserCrudController::class);
          
    }

}
