<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Account;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getRepository(Account::class);
        var_dump($em->find(1));
        
        return $this->render('AppBundle:Default:index.html.twig');
    }
}
