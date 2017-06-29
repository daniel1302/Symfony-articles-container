<?php
namespace AppBundle\Controller\Admin;


use AppBundle\Document\OperatingSystem;
use AppBundle\Model\DocumentManager\OperatingSystemDocumentManager;
use AppBundle\Model\DocumentManager\UserActivityDocumentManager;
use AppBundle\Utils\OSDetector;
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
        $systems = [];
        foreach (OSDetector::TYPES as $os) {
            $systems[$os] = 0;
        }

        /** @var OperatingSystemDocumentManager $osDocumentManager */
        $osDocumentManager = $this->get('app.operating_system_document_manager');

        $rows = $osDocumentManager->findAll();
        /** @var OperatingSystem $row */
        foreach ($rows as $row) {
            if (isset($systems[$row->getOsName()])) {
                $systems[$row->getOsName()] = $row->getNum();
            }
        }

        return $this->render('AppBundle:Admin/Stats:os.html.twig', [
            'systems' => $systems
        ]);
    }
}