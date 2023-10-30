<?php

namespace Codilar\TrackingBundle\EventListener;

use Psr\Log\LoggerInterface;
use Codilar\TrackingBundle\Model\TrackingDetails;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Pimcore\Security\User\TokenStorageUserResolver;

class CustomBackendLoggerListener implements EventSubscriberInterface
{
    private $logger;
    protected TokenStorageUserResolver $userResolver;

    public function __construct(TokenStorageUserResolver $userResolver, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->userResolver = $userResolver;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if (!$event->isMainRequest()) {
            return;
        }

        // Check if the request path contains '/admin' to log only backend admin panel activity.
        if (strpos($request->getPathInfo(), '/admin') !== false) {
            // Determine the action and object ID
            $action = $this->determineAction($request);
            $objectId = $this->determineObjectId($request);
            $login = $this->loginTime($request);
            $logout = $this->logoutTime($request);

            // Log the activity
            $this->logPimcoreBackendActivity($request, $action, $logout, $login);
            // , $objectId
        }
    }

    protected function logPimcoreBackendActivity(Request $request, $action, $logout, $login)
    {
        $activityData = [
            'request_user' => (int) $request->getUser(),
            'login_time' => $login,
            'logout' => $logout,
            'action' => $action,
            'object_id' => $this->extractObjectIdFromLogMessage($request->attributes->get('_controller')),
        ];
    
        $objectId = $activityData['object_id'] ?? 0;

        $trackingDetails = new TrackingDetails();

        $trackingDetails->setUserId($activityData['request_user']);
        $loginTime = $activityData['login_time'] instanceof \DateTime ? $activityData['login_time'] : null;

        $trackingDetails->setLogin($loginTime);
        $trackingDetails->setLogout($activityData['logout'] instanceof \DateTime ? $activityData['logout'] : null);
    
        $trackingDetails->setAction($activityData['action']);
        $trackingDetails->setObjectId($objectId);
    
        $trackingDetails->save();
    
        $this->logger->info('Pimcore Backend Activity', $activityData);

    }

    
    protected function loginTime(Request $request)
    {
        
        $pathInfo = $request->getPathInfo();
        if (strpos($pathInfo, '/admin/login') !== false) {
            return new \DateTime();
        } else {
            return null;
        }
    }
    protected function logoutTime(Request $request)
    {
        
        $pathInfo = $request->getPathInfo();
        if (strpos($pathInfo, '/admin/logout') !== false) {
            return new \DateTime();
        } else {
            return null;
        }
    }
    
    protected function extractUserIdFromLogMessage(string $logMessage)
    {
        $matches = [];
        if (preg_match('/saveAction \[(\d+),/', $logMessage, $matches)) {
            return $matches[1];
        }
        return null;
    }

    protected function extractObjectIdFromLogMessage(string $logMessage)
    {
        $matches = [];
        if (preg_match('/"id":"(\d+)"/', $logMessage, $matches)) {
            return $matches[1];
        }
        return null;
    }
    protected function determineAction(Request $request)
    {
        // Implement your logic to determine the action (document, asset, objects, classes).
        // You can check the request path, headers, or other criteria to determine this.
        // Return one of 'document', 'asset', 'objects', 'classes'.
        $pathInfo = $request->getPathInfo();
        if (strpos($pathInfo, '/admin/document') !== false) {
            return 'document';
        } elseif (strpos($pathInfo, '/admin/asset') !== false) {
            return 'asset';
        } elseif (strpos($pathInfo, '/admin/object') !== false) {
            return 'objects';
        } elseif (strpos($pathInfo, '/admin/classes') !== false) {
            return 'classes';
        } else {
            return 'unknown'; // You can set a default value for other cases.
        }
    }

    protected function determineObjectId(Request $request)
    {
        // Implement your logic to determine the object ID.
        // You may extract it from the request path or other sources.
        // Return the object ID.
        // Extract the object ID from the request path.
        $pathInfo = $request->getPathInfo();

        // Define a regular expression pattern to match object IDs in the URL.
        $pattern = '/\/admin\/(document|asset|object|classes)\/(\d+)/';

        // Use preg_match to find matches.
        if (preg_match($pattern, $pathInfo, $matches)) {
            // $matches[2] will contain the object ID.
            return (int) $matches[2];
        } else {
            return 0; // Set a default value or return 0 if an object ID is not found.
        }
    }
}
