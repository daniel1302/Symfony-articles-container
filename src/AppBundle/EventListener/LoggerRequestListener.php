<?php
namespace AppBundle\EventListener;


use AppBundle\Document\UserActivity;
use AppBundle\Model\DocumentManager\DocumentManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LoggerRequestListener
{
    /**
     * @var DocumentManagerInterface
     */
    private $documentManager;

    /**
     * LoggerRequestListener constructor.
     * @param DocumentManagerInterface $documentManager
     */
    public function __construct(DocumentManagerInterface $documentManager)
    {
        $this->documentManager = $documentManager;
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
        $userActivity->setUserAgent($request->server->get('USER_AGENT'));
        $userActivity->setUTime(microtime(true));

        $this->documentManager->insert($userActivity);
    }
}
