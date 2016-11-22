<?php

namespace CourseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function indexAction()
    {
        return $this->render('CourseBundle:Test:index.html.twig');
    }
}
