<?php

namespace App\Controller;

use Pimcore\Model\DataObject\Classificationstore;
use \Pimcore\Model\DataObject;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Blockclass;
use Pimcore\Model\DataObject\Product;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\ClassDefinition\Data\Field\Text;
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

        $blockdata = Blockclass::getById(5);

        // locking fields 
        $class = DataObject\ClassDefinition::getById('home');
        $fields = $class->getFieldDefinitions();
        foreach ($fields as $field) {
            $field->setLocked(true);
        }
        $class->save();

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

        // dump($myObject);
        // exit;

        return $this->render('apis/actions.html.twig', [
            'blockdata' => $blockdata,
        ]);

    }

    // external system interaction 
    #[Route('/products/tshirt/{sku}/{name}')]
    public function previewGenerator(Request $request, string $sku,string $name ): Response
    {
        

        return $this->render('linkgenerate/testing.html.twig', [
            'sku' => $sku,
            'name' => $name,
        ]);


    }
    
    
    // #[Route('/brick_traffic')]
    // public function csvExport(Request $request): Response
    // {
    //     // $file = fopen("export.csv", "w");

    //     // $entries = new DataObject\Blockclass\Listing();
    //     // $entries->setCondition("name LIKE ?", "%bernie%");

    //     // foreach ($entries as $entry) {
    //     //     fputcsv($file, [
    //     //         'id' => $entry->getId(),
    //     //         'name' => $entry->getName()
    //     //     ]);
    //     // }

    //     // fclose($file);

    // }





}