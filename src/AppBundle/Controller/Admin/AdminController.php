<?php

namespace AppBundle\Controller\Admin;


use AppBundle\Document\UserActivity;
use Facile\MongoDbBundle\Capsule\Database;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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
    public function indexAction(Request $request)
    {

        return $this->render('AppBundle:Admin/Admin:index.html.twig', []);
    }
}
