<?php

namespace AppBundle\Form;

use AppBundle\Entity\ArticleContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class ArticleContentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('type', ChoiceType::class, [
                    'choices' => [
                        'HTML' => ArticleContent::TYPE_HTML,
                        'Latex'  => ArticleContent::TYPE_LATEX,
                    ]
                ])
            ->add('short', TextareaType::class, [
                'label' => 'Streszczenie'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Treść',
                'attr'  => [
                    'rel' => 'markitup-markdown'
                ]
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ArticleContent::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_article_content';
    }


}
