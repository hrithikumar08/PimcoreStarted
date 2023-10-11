<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\Asset;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MyAssetController extends FrontendController
{
    public function protectedAssetAction(Request $request): Response
    {
        // IMPORTANT!
        // Add your code here to check permission!

        // Define the asset ID you want to restrict access to
        $restrictedAssetId = 6;

        // Get the asset by its ID
        $asset = Asset::getById($restrictedAssetId);

        // Check if the asset exists and if it's of the expected type (e.g., PDF)
        if ($asset instanceof Asset && $asset->getType() === 'pdf') {
            // Add your permission checking logic here
            // For example, you can check if the user is authenticated or has specific roles.
            // If the user does not have the required permissions, throw an AccessDeniedHttpException.
            if (!$this->isUserAuthorized()) {
                throw new AccessDeniedHttpException('Access denied.');
            }

            // If the user is authorized, deliver the asset content
            $stream = $asset->getStream();
            return new StreamedResponse(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                'Content-Type' => 'application/pdf',
            ]);
        }

        // If the asset doesn't exist or is not the expected type, or if the user is not authorized,
        // throw an AccessDeniedHttpException.
        throw new AccessDeniedHttpException('Access denied.');
    }

    // Add your permission checking logic here
    private function isUserAuthorized()
    {
        // Implement your authorization logic here.
        // For example, check if the user has the necessary role or permission to access the asset.
        return true; // Return true if authorized, or false if not authorized.
    }
}
