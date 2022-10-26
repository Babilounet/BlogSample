<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->redirect($this->adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Blogsample');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Back to the blog', 'fa fa-undo', 'app_home');
        yield MenuItem::linkToCrud('Articles', 'fa fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-newspaper', Category::class);
        yield MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class);
    }
}
