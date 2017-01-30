<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 30.01.17
 * Time: 00:42
 */

namespace AppBundle\Controller;


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

        return $this->render('AppBundle:Article:index.html.twig', [
            'articles' => $repositoryArticles->findAll()
        ]);
    }

    public function showAction(Request $request, Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();


        $commentForm = $this->createCommentForm($comment);

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setCreated(new \DateTime('now'));
            $comment->setArticle($article);
            $comment->setAuthor($this->getUser());

            $em->persist($comment);
            $em->flush();
            $this->addFlash('message', 'Komentarz został dodany');
            return $this->redirectToRoute('article_show', ['slug' => $article->getSlug()]);
        }



        return $this->render('AppBundle:Article:show.html.twig', [
            'article'       => $article,
            'commentForm'   =>  $commentForm->createView(),
            'content'       => $this->get('app.article_parser')->parse($article->getContent()->getContent())
        ]);
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $article = new Article();

        $form = $this->createArticleForm($article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $article->setAuthor($this->getUser());
            $article->setCreated(new \DateTime('now'));
            $article->getContent()->setCreated(new\DateTime('now'));
            $article->setSlug(Slugger::slugify($article->getTitle()));
            $article->setStatus(1);

            $em->persist($article->getContent());
            $em->persist($article);
            $em->flush();
        }

        return $this->render('AppBundle:Article:new.html.twig', [
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