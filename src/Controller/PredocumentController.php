<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PredocumentController extends FrontendController
{
    // #[Template('content/default.html.twig')]
    // public function defaultAction (Request $request): array
    // {
    //     return [];
    // }

    public function preDocument(Request $request): Response
    {
        return $this->render('traffic/predefinedoc.html.twig');
    }

}