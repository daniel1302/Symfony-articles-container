<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Test;
use AppBundle\Utils\Slugger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Question;

/**
 * Test controller.
 *
 */
class TestController extends Controller
{
    /**
     * Lists all test entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tests = $em->getRepository('AppBundle:Test')->findAll();

        return $this->render('AppBundle:Admin/Test:index.html.twig', array(
            'tests' => $tests,
        ));
    }

    /**
     * Creates a new test entity.
     *
     */
    public function newAction(Request $request)
    {
        $test = new Test();
        $form = $this->createForm('AppBundle\Form\TestType', $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $test->setSlug(Slugger::slugify($test->getName()));
            $test->setActive(1);
            $test->setAuthor($this->getUser());
            $test->setCreated(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($test);
            $em->flush($test);

            return $this->redirectToRoute('admin_test_show', array('id' => $test->getId()));
        }

        return $this->render('AppBundle:Admin/Test:new.html.twig', array(
            'test' => $test,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a test entity.
     *
     */
    public function showAction(Test $test)
    {
        $deleteForm = $this->createDeleteForm($test);
        $repositoryQuestion = $this->getDoctrine()->getRepository(Question::class);
        
        
        
        
        return $this->render('AppBundle:Admin:Test/show.html.twig', array(
            'test'          => $test,
            'questions'     => $repositoryQuestion->getSortedForTest($test),
            'delete_form'   => $deleteForm->createView(),
        ));
    }
    
    public function sortAction(Request $request, Test $test)
    {
        $order = $request->request->get('order');
        
        $em = $this->getDoctrine()->getManager();
        
        $questions = $em->getRepository(Question::class)->findByTest($test);
        
        foreach ($questions as $question) {
            $key = (int)array_search($question->getId(), $order);
            
            $question->setOrderNo($key);
            $em->persist($question);
        }
        
        $em->flush();
        
        return new JsonResponse(['status' => 200, 'message' => 'OK']);
    }

    /**
     * Displays a form to edit an existing test entity.
     *
     */
    public function editAction(Request $request, Test $test)
    {
        $deleteForm = $this->createDeleteForm($test);
        $editForm = $this->createForm('AppBundle\Form\TestType', $test);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $test->setSlug(Slugger::slugify($test->getName()));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_test_edit', array('id' => $test->getId()));
        }

        return $this->render('AppBundle:Admin:Test/edit.html.twig', array(
            'test' => $test,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a test entity.
     *
     */
    public function deleteAction(Request $request, Test $test)
    {
        $form = $this->createDeleteForm($test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($test);
            $em->flush($test);
        }

        return $this->redirectToRoute('admin_test_index');
    }

    /**
     * Creates a form to delete a test entity.
     *
     * @param Test $test The test entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Test $test)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_test_delete', array('id' => $test->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
