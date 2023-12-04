<?php

namespace Codilar\UserBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends FrontendController
{
    /**
     * @Route("/codilar_user")
     */
    public function indexAction(Request $request): Response
    {
        return new Response('Hello world from codilar_user');
    }
}
