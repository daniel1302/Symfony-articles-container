<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Test;
use AppBundle\Entity\Question;

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
        
        $question = $repositoryQuestion->getQuestionForTest($test, $questionNo);
                
        
        return $this->render('AppBundle:Test:start.html.twig', [
            'test'  => $test
        ]);
    }
}
