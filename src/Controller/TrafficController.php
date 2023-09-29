<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrafficController extends FrontendController
{
    #[Template('content/default.html.twig')]
    public function defaultAction (Request $request): array
    {
        return [];
    }

    #[Template('traffic/frontpage.html.twig')]
    public function trafficAction(Request $request): Response
    {
        // $navigationItems = \Pimcore\Model\Document\NavigationItem::getList([
        //     'published' => true,
        // ]);

        $page = new \Pimcore\Model\Document\Page();
        $page->setKey('document8');
        $page->setParentId(1); // id of a document or folder
        
        return $this->render('traffic/frontpage.html.twig');
    }

    
    // public function preDocument(Request $request): Response
    // {
    //     return $this->render('traffic/predefinedoc.html.twig');
    // }
}