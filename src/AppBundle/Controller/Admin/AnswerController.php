<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Question controller.
 *
 */
class AnswerController extends Controller
{
    /**
     * Creates a new question entity.
     *
     */
    public function newAction(Request $request, Question $question)
    {
        $answer = new Answer();
        $form = $this->createForm('AppBundle\Form\AnswerType', $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            
            $answer->setAuthor($this->getUser());
            $answer->setQuestion($question);
            
            $em->persist($answer);
            $em->flush($answer);

            return $this->redirectToRoute('admin_question_edit', array('id' => $question->getId()));
        }

        return $this->render('AppBundle:Admin/Answer:new.html.twig', array(
            'question' => $question,
            'answer'   => $answer,
            'form'     => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing question entity.
     *
     */
    public function editAction(Request $request, Answer $answer)
    {
        $deleteForm = $this->createDeleteForm($answer);
        $editForm = $this->createForm('AppBundle\Form\AnswerType', $answer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_question_edit', array('id' => $answer->getQuestion()->getId()));
        }

        return $this->render('AppBundle:Admin/Answer:edit.html.twig', array(
            'answer' => $answer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a question entity.
     *
     */
    public function deleteAction(Request $request, Answer $answer)
    {
        $form = $this->createDeleteForm($question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush($question);
        }

        return $this->redirectToRoute('admin_question_show', ['id' => $answer->getQuestion()->getId()] );
    }

    /**
     * Creates a form to delete a question entity.
     *
     * @param Question $question The question entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Answer $answer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_answer_delete', array('id' => $answer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
