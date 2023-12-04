<?php

namespace Codilar\UserBundle\Controller;

use Pimcore\Controller\FrontendController;
use Codilar\UserBundle\Model\Listing;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\Tool\SettingsStore;

class UserController extends FrontendController
{

    #[Route("/get_api_key/{userId}", methods: ["GET"])]
    public function getApiKey(Request $request, string $userId): JsonResponse
    {
        $existing = SettingsStore::getIdsByScope('bundles/Codilar/UserBundle');

        if (empty($existing)) {
            // No existing settings found, return an error response
            return new JsonResponse(['error' => 'User not found']);
        }
        // , 404

        $Id = $existing[0];
        $existingData = SettingsStore::get($Id, 'bundles/Codilar/UserBundle');

        if (!$existingData) {
            return new JsonResponse(['error' => 'User data not found']);
        }

        $existingDataArray = json_decode($existingData->getData(), true);

        if (isset($existingDataArray[$userId])) {
            $apiKey = $existingDataArray[$userId];

            return new JsonResponse(['apikey' => $apiKey]);
        } else {
            return new JsonResponse(['error' => 'API key not found for the user']);
        }
    }

    #[Route("/save_setting_data", methods: ["POST"])]
    public function saveSettingData(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $settingId = $data['id'];
        $settingScope = 'bundles/Codilar/UserBundle';
        $exist = SettingsStore::getIdsByScope($settingScope);

        if (empty($exist)) {
            $settingData = json_encode([$data['id'] => $data['apikey']]);
            $settingType = 'string';
            SettingsStore::set($settingId, $settingData, $settingType, $settingScope);

        } else {

            $ids = $exist[0];
            $exist = SettingsStore::get($ids, $settingScope);

            $existingData = json_decode($exist->getData(), true);
            $existingData[$data['id']] = $data['apikey'];

            $settingData = json_encode($existingData);
            $settingType = 'string';

            SettingsStore::set($ids, $settingData, $settingType, $settingScope);
        }

        return new JsonResponse(['message' => 'Data saved successfully']);
    }


    #[Route("/users_detail")]
    public function userAction(Request $request): Response
    {
        $listing = new Listing();
        // $listing->setCondition('id=3');
        $listing->load();

        $formattedData = [];
        foreach ($listing as $item) {
            $formattedData[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'firstName' => $item->getFirstname(),
                'lastName' => $item->getLastname(),
                'emailid' => $item->getEmail(),
            ];
        }

        return new JsonResponse(['list' => $formattedData]);


    }


}
