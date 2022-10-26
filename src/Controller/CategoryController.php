<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{slug}', name: 'category_show')]
    public function show(Category $oCategoryEntity): Response
    {

        if (!$oCategoryEntity) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('category/show.html.twig', [
            'category' => $oCategoryEntity,
        ]);
    }
}
