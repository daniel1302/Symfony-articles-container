<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Question;
use AppBundle\Entity\Test;
use AppBundle\Entity\Answer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Question controller.
 *
 */
class QuestionController extends Controller
{
    /**
     * Creates a new question entity.
     *
     */
    public function newAction(Request $request, Test $test)
    {
        $question = new Question();
        $form = $this->createForm('AppBundle\Form\QuestionType', $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $question->setAuthor($this->getUser());
            $question->setCreated(new \DateTime('now'));
            $question->setTest($test);
            
            $em->persist($question);
            $em->flush($question);

            return $this->redirectToRoute('admin_test_show', array('id' => $test->getId()));
        }

        return $this->render('AppBundle:Admin/Question:new.html.twig', array(
            'question' => $question,
            'test'     => $test,
            'form'     => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing question entity.
     *
     */
    public function editAction(Request $request, Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('AppBundle\Form\QuestionType', $question);
        $editForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_question_edit', array('id' => $question->getId()));
        }

        return $this->render('AppBundle:Admin/Question:edit.html.twig', array(
            'question'    => $question,
            'test'        => $question->getTest(),
            'answers'     => $em->getRepository(Answer::class)->getSortedForQuestion($question),
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    public function sortAction(Request $request, Question $question)
    {
        $order = $request->request->get('order');
        
        $em = $this->getDoctrine()->getManager();
        
        $answers = $em->getRepository(Answer::class)->findByQuestion($question);
        
        
        foreach ($answers as $answer) {
            $key = (int)array_search($answer->getId(), $order);
            $answer->setOrderNo($key);
            $em->persist($answer);
        }
        
        $em->flush();
        
        return new JsonResponse(['status' => 200, 'message' => 'OK']);
    }

    /**
     * Deletes a question entity.
     *
     */
    public function deleteAction(Request $request, Question $question)
    {
        $form = $this->createDeleteForm($question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush($question);
        }

        return $this->redirectToRoute('admin_test_show', ['id' => $question->getTest()->getId()] );
    }

    /**
     * Creates a form to delete a question entity.
     *
     * @param Question $question The question entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Question $question)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_question_delete', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
