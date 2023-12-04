<?php

namespace Codilar\CustomBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimcore\Model\DataObject\ProductStore;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// where is your template folder of bundles ? 
class PreviewController extends AbstractController
{
    /**
     * @Route("preview")
     */
    public function preAction(Request $request): Response
    {

        // $prod = ProductStore::getById(35);
        // dump($prod);

        $productId = $request->query->get('id');

        $prod = ProductStore::getById($productId);
        
        return $this->render('@CodilarCustom/preview.html.twig', [
            'prod' => $prod,
        ]);
        
    }
}

// dump($blockObject);
// return new Response('This is the response content.');