<?php

namespace App\Controller;

use Pimcore\Model\DataObject\Classificationstore;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Blockclass;
use Pimcore\Model\DataObject\Challandetails;
use Pimcore\Model\DataObject\Trafficalert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrafficController extends FrontendController
{

    public function trafficAction(Request $request): Response
    {

        $blockObject = Blockclass::getById(3);
        $blockClass = $blockObject->getBlock();

        $challan = Challandetails::getById(4);

        return $this->render('traffic/frontpage.html.twig', [
            'blockClass' => $blockClass,
            'challan' => $challan,
        ]);

    }

    #[Route('/brick_traffic')]
    public function trobjectBrick(Request $request): Response
    {

        $tadata = Trafficalert::getById(5);
        $dataObject = Trafficalert::getById(5);

        // Get the classification store for the Trafficalert object class
        $classificationStore = $dataObject->getInfoClassification();

        $infoClassification = [];
        foreach ($classificationStore->getGroups() as $group) {
            foreach ($group->getKeys() as $key) {
                $infoClassification[] = [
                    'key' => $key->getConfiguration()->getName(),
                    'value' => $key->getValue(),
                ];
            }
        }

        return $this->render('traffic/objects.html.twig', [
            'tadata' => $tadata,
            'infoClassification' => $infoClassification,
        ]);

    }

}