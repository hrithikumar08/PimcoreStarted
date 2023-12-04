<?php

namespace App\ManualBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
   
    // #[Route('/manual-bundle')]
    public function index(): Response
    {
        // return $this->render('ManualBundle:index.html.twig');
        return new Response('Working');
    }


    
}
