<?php

namespace App\Controller;

use Pimcore\Model\DataObject\Classificationstore;
use \Pimcore\Model\DataObject;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Blockclass;
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

class TrafficController extends FrontendController
{
    #[Route('/homes')]
    public function trafficAction(Request $request): Response
    {
        // $language = $this->getRequest()->getLocale();

        $blockObject = Blockclass::getById(3);
        $blockClass = $blockObject->getBlock();

        $challan = ChallanDetails::getById(4);

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

        //    // Create a new object
        //    $newObject = new DataObject\Trafficalert();
        //    $newObject->setKey(\Pimcore\Model\Element\Service::getValidKey('NewName', 'object'));
        //    $newObject->setParentId(4);
        //    // $newObject->setAlert("Test Name");
        //    // $newObject->setDescription("Testing New Object Creation from code ");
        //    $newObject->save();

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

    #[Route('/apis')]
    public function traffiApi(Request $request): Response
    {
        //  // The asset path you want to restrict access to
        //  $restrictedAssetPath = "/Product/challan.png";

        //  // Get the path of the requested URL
        //  $requestPath = $request->getPathInfo();
 
        //  // Check if the requested path matches the restricted asset path
        //  if ($requestPath === $restrictedAssetPath) {
        //      // If it's a direct request to the restricted asset, throw an AccessDeniedHttpException.
        //      throw new AccessDeniedHttpException('Access denied.');
        //  }

        $blockdata = Blockclass::getById(5);

        // locking fields 
        $class = DataObject\ClassDefinition::getById('home');
        $fields = $class->getFieldDefinitions();
        foreach ($fields as $field) {
            $field->setLocked(true);
        }
        $class->save();

        // //creating and saving new asset
        // $newAsset = new \Pimcore\Model\Asset();
        // $newAsset->setFilename("google-logo.png");
        // $newAsset->setData(file_get_contents("https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png"));
        // // $newAsset->setData(file_get_contents("/home/All Codes/Assests/images/pimcorelogo.png"));
        // $newAsset->setParent(\Pimcore\Model\Asset::getByPath("/"));
        // $newAsset->save();

        //getting assets
        // $asset1 = Asset::getById(11);
        // if ($asset1 != null) {
        //     $asset1->delete();
        // }

        $videoAsset = Asset\Video::getById(13);
            // echo $asset . '<br>';
            // Do something with the asset
        

        $assetDoc = Asset::getById(14);
        if($assetDoc instanceof Asset\Document) {
        //  echo "helo"; 

        //    // get a thumbnail of the first page, resized to the configuration of "myThumbnail"
        //    echo $assetDoc->getImageThumbnail("image_transform");
             $thumbnailUrl = $assetDoc->getImageThumbnail('image_transform');
            //  echo  $thumbnailUrl;
           // get the thumbnail URL for all pages, but do not generate them immediately (see third parameter) - the thumbnails are then generated on request
        //    $thumbnailUrls = [];
        //    for($i=1; $i<=$assetDoc->getPageCount(); $i++) {
        //       $thumbnailUrls[] = $assetDoc->getImageThumbnail("image_transform", $i, true);
        //    }
        }
         
        


        // // Create a new object
        // $objectKey = 'customobject';
        // // Get all objects of the same class
        // $objects = new DataObject\Blockclass\Listing();
        // $objectExists = false;

        // foreach ($objects as $object) {
        //     // dump($object);
        //     // $var = $object->getKey();
        //     // echo $var;
        //     if ($object->getKey() == $objectKey) {
        //         // The object with the specified key exists
        //         $objectExists = true;
        //         break;
        //     }
        // }

        // if (!$objectExists) {
        //     // The object doesn't exist, so create it
        //     $newObject = new DataObject\Blockclass();
        //     $newObject->setKey(\Pimcore\Model\Element\Service::getValidKey($objectKey, 'object'));
        //     $newObject->setParentId(1);
        //     $newObject->save();
        // }

        //getting objects
        $myObject = DataObject\Blockclass::getById(3);
        $blockData = $myObject->getBlock();

        //reading block object data 
        $number = $myObject->getBlock()[0]['number']->getData();
        $email = $myObject->getBlock()[0]['email']->getData();

        foreach ($blockData as $blockEntry) {
            $number = $blockEntry['number']->getData();
            $email = $blockEntry['email']->getData();

            // echo "Number: $number, Email: $email<br>";
        }

        // Updating email and number from code of block objects
        // foreach ($blockData as $blockEntry) {
        //     if (isset($blockEntry['number']) == '9546842357' && isset($blockEntry['email']) == 'blrtraffic@outlook.com' ) {
        //         // Set new values for number and email
        //         $blockEntry['number']->setData('7589743610');
        //         $blockEntry['email']->setData('edited@gmail.com');

        //         // Save the object to persist the changes
        //         $myObject->save();
        //     }
        // }

        // Remove the email property 'edited@gmail.com'
        // foreach ($blockData as $blockEntry) {
        //     if (isset($blockEntry['email']) && $blockEntry['email']->getData() == 'edited@gmail.com') {
        //         unset($blockEntry['email']); // Remove the email property
        //     }
        // }
        // Save the object to persist the changes
        // $myObject->save();

        // in your controller / action
        // $locale = $request->getLocale(); 
        //or 
        // $language = $this->document->getProperty("language");
        
        // any document
        // $doc = Document::getById(3);
        // $language = $doc->getProperty("language");
        // dump($doc);


        return $this->render('apis/actions.html.twig', [
            'blockdata' => $blockdata,
            'video' => $videoAsset,
            'thumbnailUrl' => $thumbnailUrl,
        ]);

    }

    // external system interaction 
    #[Route('/products/tshirt/{sku}/{name}')]
    public function previewGenerator(Request $request, string $sku, string $name): Response
    {

        return $this->render('linkgenerate/testing.html.twig', [
            'sku' => $sku,
            'name' => $name,
        ]);


    }



}