<?php

namespace Codilar\MagentoConnectorBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\Blockclass;
use Codilar\MagentoConnectorBundle\Service\ApiService;

class ApiController extends FrontendController
{

    private $apiAuthService;

    public function __construct(ApiService $apiAuthService)
    {
        $this->apiAuthService = $apiAuthService;
    }

    /**
     * @Route("/api/magento_connector/{id}", name="magento_getdata", methods={"GET", "POST"})
     */
    public function getDataAction(Request $request, $id)
    {
        if (!$this->apiAuthService->authenticate($request)) {
            return new JsonResponse(['error' => 'not authorized', 'message' => 'incorrect api key ']);
        }

        $dataObject = Blockclass::getById($id);

        if (!$dataObject instanceof Blockclass) {
            return new JsonResponse(['error' => 'not found', 'message' => 'You hit a GET/POST request']);
        }

        $requestMethod = $request->getMethod();

        $blockData = $dataObject->getBlock();
    
        $allData = [];
    
        foreach ($blockData as $blockElement) {
            $formattedBlockElement = [];
    
            foreach ($blockElement as $fieldName => $field) {
                echo 'fields name => '.$fieldName." fields => ".$field."\n";
                $formattedBlockElement[$fieldName] = $field->getData();
            }
    
            $allData[] = $formattedBlockElement;
        }

        return new JsonResponse(['data' => $allData, 'message' => "You hit a $requestMethod request"]);
    }

    /**
     * @Route("/api/magento_connector/create/{name}", name="magento_create", methods={"GET", "POST"})
     */
    public function createDataAction(Request $request, $name)
    {

        if (!$this->apiAuthService->authenticate($request)) {
            return new JsonResponse(['error' => 'not authorized', 'message' => 'incorrect api key ']);
        }

        $newDataObject = new Blockclass();
        $newDataObject->setKey($name); 
        $newDataObject->setParentId(50);


        // $dataObject = Blockclass::getById($newDataObject->getId());
        // $blockData = $dataObject->getBlock();
    
        // $allData = [];
    
        // foreach ($blockData as $blockElement) {
        //     $formattedBlockElement = [];
    
        //     foreach ($blockElement as $fieldName => $field) {
        //         $formattedBlockElement[$fieldName] = $field->getData();
        //     }
    
        //     $allData[] = $formattedBlockElement;
        // }
        
        $newDataObject->save();

        // print_r($allData);
        
        $requestMethod = $request->getMethod();

        return new JsonResponse(['message' => 'created successfully', 'id' => $newDataObject->getId(), 'messages' => "You hit a $requestMethod request"]);
    }
}

        
// $formattedBlockData = array_map(function ($blockElement) {
//     return [
//         'title' => $blockElement['title']->getData(),
//         'number' => $blockElement['number']->getData(),
//         'email' => $blockElement['email']->getData(),
//         'location' => $blockElement['location']->getData(),
//         'office' => $blockElement['office']->getData(),
//         'structtable' => $blockElement['structtable']->getData(),
//     ];
// }, $blockData);