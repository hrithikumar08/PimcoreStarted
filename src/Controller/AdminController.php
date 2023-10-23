<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends FrontendController
{
  
    public function defaultAction(Request $request): Response
    {
        return new Response('This is the response content.');
    }
    
}


?>
