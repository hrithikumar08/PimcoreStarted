<?php

namespace Codilar\TrackingBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;

class SettingController extends FrontendController
{
    /**
     * @Route("/save-setting", methods={"GET"})
     */
    public function settingAction(Request $request): JsonResponse
    {
 
        $formData = $request->get('data');
    
        $formData = json_decode($formData, true);
        // var_dump($formData);
    
        $storingYML = $this->getParameter('kernel.project_dir') . '/bundles/Codilar/systemsettings/save.yaml';
    
        $yaml = Yaml::dump($formData);
    
        if (!file_put_contents($storingYML, $yaml)) {
            return new JsonResponse(['message' => 'something wrong']);
        }
    
        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/load-yaml-data")
     */
    public function loadYamlData(Request $request): Response
    {
        $yamlFilePath = $this->getParameter('kernel.project_dir') . '/bundles/Codilar/systemsettings/save.yaml';
        
        if (file_exists($yamlFilePath)) {
            $yamlData = file_get_contents($yamlFilePath);
            $parsedData = Yaml::parse($yamlData);

            return new JsonResponse($parsedData);
        } else {
            return new JsonResponse(['error' => 'YAML file not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
