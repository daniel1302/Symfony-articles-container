<?php

namespace AppBundle\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Question controller.
 *
 */
class AdminController extends Controller
{
    /**
     * Creates a new question entity.
     *
     */
    public function indexAction()
    {
       
        return $this->render('AppBundle:Admin/Admin:index.html.twig', []);
    }
}
