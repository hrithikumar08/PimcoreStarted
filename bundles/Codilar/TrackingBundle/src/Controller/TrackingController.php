<?php

namespace Codilar\TrackingBundle\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\AbstractModel;
use Pimcore\Model\User;
use Codilar\TrackingBundle\Model\Listing;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrackingController extends FrontendController
{
    /**
     * @Route("/tracking")
     */
    public function trackAction(Request $request): Response
    {
        $listing = new Listing();
        $listing->setCondition('objectId =35');
        $listing->load();
        
        $formattedData = [];
        
        foreach ($listing as $item) {
            $formattedData[] = [
                'userId' => $item->getUserId(),
                'login' => $item->getLogin()->format('Y-m-d H:i:s'),
                'logout' => $item->getLogout()->format('Y-m-d H:i:s'),
                'action' => $item->getAction(),
                'objectId' => $item->getObjectId(),
            ];
        }
        
        return new JsonResponse(['list' => $formattedData]);
        
        // return $this->render('@CodilarTracking/view.html.twig',[
        //     'list' => $listing
        // ]);
    }
}
