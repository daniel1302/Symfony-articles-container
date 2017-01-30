<?php
namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Tag;
use AppBundle\Form\TagType;
use AppBundle\Utils\Slugger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine();
        $repositoryTag = $em->getRepository(Tag::class);

        $tags = $repositoryTag->findAll();

        return $this->render('AppBundle:Admin/Tag:index.html.twig', [
            'tags' => $tags
        ]);
    }

    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = new Tag();
        $form = $this->getTagForm($tag);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tag->setSlug(Slugger::slugify($tag->getName()));
            $em->persist($tag);
            $em->flush();
            $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('AppBundle:Admin/Tag:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction(Request $request, Tag $tag)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->getTagForm($tag);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tag->setSlug(Slugger::slugify($tag->getName()));
            $em->persist($tag);
            $em->flush();
            $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('AppBundle:Admin/Tag:edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function getTagForm(Tag $entity) {
        $form = $this->createForm(TagType::class, $entity, [
            
        ]);
        
        return $form;
    }
}