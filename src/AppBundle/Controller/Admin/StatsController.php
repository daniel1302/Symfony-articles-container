<?php
namespace AppBundle\Controller\Admin;


use AppBundle\Model\DocumentManager\UserActivityDocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StatsController extends Controller
{
    public function indexAction()
    {
        /** @var UserActivityDocumentManager $userActivityManager */
        $userActivityManager = $this->get('app.user_activity_document_manager');

        return $this->render('AppBundle:Admin/Stats:index.html.twig', [
            'num'   => $userActivityManager->count(),
            'rows'  => $userActivityManager->findAll([], 1000)
        ]);
    }

    public function osAction()
    {
        return $this->render('AppBundle:Admin/Stats:os.html.twig', [
            'num'   => $userActivityManager->count(),
            'rows'  => $userActivityManager->findAll([], 1000)
        ]);
    }
}