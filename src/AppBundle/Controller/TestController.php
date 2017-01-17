<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Test;
use AppBundle\Entity\Question;
use AppBundle\Entity\Answer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;

class TestController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine();        
        
        return $this->render('AppBundle:Test:index.html.twig', [
            'tests' => $em->getRepository(Test::class)->findAll()
        ]);
    }
    
    public function startAction(Request $request, Test $test)
    {
        $em = $this->getDoctrine();
        
        return $this->render('AppBundle:Test:start.html.twig', [
            'test'  => $test
        ]);
    }
    
    public function questionAction(Request $request, Test $test, $questionNo)
    {
        $em = $this->getDoctrine();
        
        $repositoryQuestion = $em->getRepository(Question::class);
        $repositoryAnswer   = $em->getRepository(Answer::class);
        $question       = $repositoryQuestion->getQuestionForTest($test, $questionNo);
        $answers        = $repositoryAnswer->getSortedForQuestion($question);
        
        $form = $this->createQuestionForm($answers);
        
        return $this->render('AppBundle:Test:question.html.twig', [
            'test'      => $test,
            'question'  => $question,
            'form'      => $form->createView()
        ]);
    }
    
    private function createQuestionForm(array $answers) {
        $type = $this->getAnswerType($answers);
        $form = $this->createFormBuilder();
        
        $answersArray = [];
        foreach ($answers as $answer) {
            $answersArray[$answer->getContent()] = $answer->getId();
        }
        
        $form->add('answers', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, [
            'choices'  => $answersArray,
            'expanded' => $type['expanded'],
            'multiple' => $type['multiple']
        ]);
        
        return $form->getForm();
    }
    
    private function getAnswerType(array $answers) {
        if ($this->countValidAnswers($answers) > 1) {
            return ['expanded' => true, 'multiple' => true];
        } 
        
        return ['expanded' => true, 'multiple' => false];
    }
    
    private function countValidAnswers(array $answers) {
        $i = 0;
        foreach($answers as $answer) {
            if ($answer->getValid()) {
                $i++;
            }
        }
        
        return $i;
    }
}
