<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 30.01.17
 * Time: 00:42
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Article;
use AppBundle\Entity\Comment;
use AppBundle\Form\ArticleType;
use AppBundle\Form\CommentType;
use AppBundle\Utils\Slugger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repositoryArticles = $em->getRepository(Article::class);

        return $this->render('AppBundle:Admin/Article:index.html.twig', [
            'articles' => $repositoryArticles->findAll()
        ]);
    }


    public function editAction(Request $request, Article $article)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createArticleForm($article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setSlug(Slugger::slugify($article->getTitle()));
            $article->setStatus(1);

            $em->persist($article->getContent());
            $em->persist($article);
            $em->flush();
        }

        return $this->render('AppBundle:Admin/Article:edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function createArticleForm($entity)
    {
        return $this->createForm(ArticleType::class, $entity, []);
    }

    private function createCommentForm($entity)
    {
        return $this->createForm(CommentType::class, $entity, []);
    }

}