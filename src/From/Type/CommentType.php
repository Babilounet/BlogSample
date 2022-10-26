<?php

namespace App\Form\Type;

use App\Entity\Article;
use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $oBuilder, array $aOptions)
    {
        $oBuilder
            ->add('content', TextareaType::class, [
                'label' => 'Your comment'
            ])
            ->add('article', HiddenType::class)
            ->add('send', SubmitType::class, [
                'label' => 'Send comment'
            ]);

        $oBuilder->get('article')->addModelTransformer(new CallbackTransformer(
            fn (Article $oArticle) => $oArticle->getId(),
            fn (Article $oArticle) => $oArticle->getTitle()
        ));
    }

    public function configureOptions(OptionsResolver $oResolver)
    {
        $oResolver->setDefaults([
            'data_class' => Comment::class,
            'csrf_token_id' => 'comment-add'
        ]);
    }
}
