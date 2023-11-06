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
    
        $yaml = Yaml::dump($formData,5);
    
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
    
    /**
     * @Route("/yaml-data")
     */
    public function showdataAction(Request $request): Response
    {
        $yamlFilePath = $this->getParameter('kernel.project_dir') . '/bundles/Codilar/systemsettings/save.yaml';
        
        if (file_exists($yamlFilePath)) {
            $yamlData = file_get_contents($yamlFilePath);
            $parsedData = Yaml::parse($yamlData);
            // dump($parsedData);
    
            // Check if 'showdata' is set to true in your YAML data
            $showData = isset($parsedData['pimcore']['showdata']['showdata']) && $parsedData['pimcore']['showdata']['showdata'] === true;
    
            if ($showData) {
                // Pass the parsed data to your Twig template
                return $this->render('@CodilarTracking/yaml.html.twig', ['parsedData' => $parsedData]);
            } else {
                return new JsonResponse(['error' => 'Permission not given']);
            }

        } else {
            return new JsonResponse(['error' => 'YAML file not found']);
        }
    }

}
