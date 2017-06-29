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
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);



        /** @var Database $mongo */
        $mongo = $this->get('mongo.connection.foo_db');





        var_dump($userActivity);


        $jsonContent = $serializer->serialize($userActivity, 'json');
var_dump($jsonContent);
        $xmlContent = $serializer->serialize($userActivity, 'xml');
        var_dump($xmlContent);
//        $mongo->createCollection('test_collection');
        $collection = $mongo->listCollections();
        foreach ($collection as $c) {
            var_dump($c);
        }die();
        return $this->render('AppBundle:Admin/Admin:index.html.twig', []);
    }
}
