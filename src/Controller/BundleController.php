<?php

namespace App\Controller;

use Pimcore\Bundle\ApplicationLoggerBundle\ApplicationLogger;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MyService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BundleController extends FrontendController
{
    private $myService;
    // private $container;

    // ,ContainerInterface $container
    public function __construct(MyService $myService)
    {
        $this->myService = $myService;
        // $this->container = $container;
    }

    #[Route('/bundle-action')]
    public function myAction(): Response
    {
        // $myService = $this->container->get('my_service');
        // $myService->doSomething();

        $this->myService->doSomething();
        // $myService = $this->container->get('my_service');
        // $myService->doSomething();
        return new Response('MyService doSomething() called');
        // return new Response('Adaptive Design Helper');
    }
}