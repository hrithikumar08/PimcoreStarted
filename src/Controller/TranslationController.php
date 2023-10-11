<?php

namespace App\Controller;

use Pimcore\Model\DataObject\Classificationstore;
use \Pimcore\Model\DataObject;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Blockclass;
use Pimcore\Model\DataObject\Language;
use Pimcore\Model\DataObject\Product;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\ClassDefinition\Data\Field\Text;
use Pimcore\Model\DataObject\ChallanDetails;
use Pimcore\Model\DataObject\Trafficalert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Pimcore\Model\Asset;
use Pimcore\Model\Document;
use Pimcore\Model\Asset\Listing;

class TranslationController extends FrontendController
{
    #[Route('/complaintus')]
    public function languageTest(Request $request): Response
    {
        $locale = $request->getLocale(); 
        $language = $this->document->getProperty("language");
        $doc = Document::getById(12);
        $language = $doc->getProperty("language");
        
        $langdata = Language::getById(30);

        return $this->render('lang/default.html.twig',[
            'language' => $language,
            'langdata' => $langdata,
        ]);

        

    }

}