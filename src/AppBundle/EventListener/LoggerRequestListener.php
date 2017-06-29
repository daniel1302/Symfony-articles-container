<?php
namespace AppBundle\EventListener;


use AppBundle\Document\OperatingSystem;
use AppBundle\Document\UserActivity;
use AppBundle\Model\DocumentManager\DocumentManagerInterface;
use AppBundle\Utils\OSDetector;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LoggerRequestListener
{
    /**
     * @var DocumentManagerInterface
     */
    private $userActivityDocumentManager;

    /**
     * @var DocumentManagerInterface
     */
    private $osDocumentManager;

    /**
     * LoggerRequestListener constructor.
     * @param DocumentManagerInterface $userActivityDocumentManager
     * @param DocumentManagerInterface $osDocumentManager
     */
    public function __construct(
        DocumentManagerInterface $userActivityDocumentManager,
        DocumentManagerInterface $osDocumentManager
    ) {
        $this->userActivityDocumentManager = $userActivityDocumentManager;
        $this->osDocumentManager = $osDocumentManager;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        $userActivity = new UserActivity();
        $userActivity->setIp($request->getClientIp());
        $userActivity->setPage($request->getRequestUri());
        $userActivity->setSessionId($request->getSession()->getId());
        $userActivity->setUserAgent($request->server->get('HTTP_USER_AGENT'));
        $userActivity->setTime(time());


//        $this->userActivityDocumentManager->insert($userActivity);

        $this->detectOS($request->server->get('HTTP_USER_AGENT'));
    }

    private function detectOS(string $userAgent)
    {
        $osName = OSDetector::fromUserAgent($userAgent);

        /** @var OperatingSystem $doc */
        $doc = $this->osDocumentManager->find(md5($osName));

        if (empty($doc)) {
            $os = new OperatingSystem();
            $os->setId(md5($osName));
            $os->setNum(1);
            $os->setOsName($osName);
            $this->osDocumentManager->insert($os);
        } else {
            $doc->setNum($doc->getNum()+1);
            $this->osDocumentManager->update($doc);
        }

        var_dump($doc);
        die();
    }
}
