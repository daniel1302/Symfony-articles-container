<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Account;

class DefaultController extends Controller
{
    public function indexAction()
    {        
        return $this->render('AppBundle:Default:index.html.twig');
    }
}
