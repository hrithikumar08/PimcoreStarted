<?php
// use Codeception\Step\Action;
// use Pimcore\Tool\DeviceDetector;
// use Symfony\Component\HttpFoundation\Response;

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// class DesignController extends Action
class DesignController extends FrontendController
{
    // #[Route('/adaptive')]
    // public function testAction(): Response
    // {
    //     $device = DeviceDetector::getInstance();
    //     $device->getDevice(); // returns "phone", "tablet" or "desktop"
 
    //     if($device->isDesktop() || $device->isTablet()) {
    //         // do something
    //     }
        
    //     // ...

    //     return new Response('Adaptive Design Helper');
    // }
}