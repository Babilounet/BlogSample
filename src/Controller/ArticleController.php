<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Article $oArticleEntity): Response
    {
        if (!$oArticleEntity) {
            return $this->redirectToRoute('app_home');
        }

        $oCommentEntity = new Comment($oArticleEntity);

        $oCommentFrom = $this->createForm(CommentType::class, $oCommentEntity);
        return $this->renderForm('article/show.html.twig', [
            'article' => $oArticleEntity,
            'commentForm' => $oCommentFrom
        ]);
    }
}
