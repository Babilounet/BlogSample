<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/ajax/comments', name: 'comment_add')]
    public function add(Request $oRequest, ArticleRepository $oArticleRepository, UserRepository $oUserRepository, EntityManagerInterface $oEntityManager, CommentRepository $oCommentRepository): Response
    {
        $aCommentData = $oRequest->request->all('comment');

        if (!$this->isCsrfTokenValid('comment-add', $aCommentData['_token'])) {
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN',
                Response::HTTP_BAD_REQUEST
            ]);
        }

        $oArticleEntity = $oArticleRepository->findOneBy(['id' => $aCommentData['article']]);
        if (!$oArticleEntity) {
            return $this->json([
                'code' => 'ARTICLE_NOT_FOUND',
                Response::HTTP_BAD_REQUEST
            ]);
        }


        // TODO : Fix the user entity finding with real users
        $oUserEntity = $oUserRepository->findOneBy(['id' => 1]);
        if (!$oUserEntity) {
            return $this->json([
                'code' => 'USER_NOT_FOUND',
                Response::HTTP_BAD_REQUEST
            ]);
        }

        $oCommentEntity = new Comment($oArticleEntity);
        $oCommentEntity->setUser($oUserEntity);
        $oCommentEntity->setContent($aCommentData['content']);
        $oCommentEntity->setCreatedAt(new \DateTime());

        $oEntityManager->persist($oCommentEntity);
        $oEntityManager->flush();

        $sHtml = $this->renderView('comment/index.html.twig', [
            'comment' => $oCommentEntity
        ]);

        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'message' => $sHtml,
            'numberOfComment' => $oCommentRepository->count(['article' => $oArticleEntity]),
            Response::HTTP_OK
        ]);
    }
}
