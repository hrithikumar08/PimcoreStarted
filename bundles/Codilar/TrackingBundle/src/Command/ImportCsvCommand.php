<?php

namespace Codilar\TrackingBundle\Command;

use Symfony\Component\Console\Command\Command;
use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\Csvparse;
use Pimcore\Model\DataObject\Objectbrick\Data\Csvbrick;
use Pimcore\Model\DataObject\Data;
use Pimcore\Console\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Pimcore\Model\DataObject\Data\NumericRange;


class ImportCsvCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('codilar:tracking:import-csv')
            ->setDescription('Imports CSV data into the Csvparse class.')
            ->addArgument('csv-file', InputArgument::REQUIRED, 'The path to the CSV file to import.');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $csvFilePath = $input->getArgument('csv-file');

        if (!file_exists($csvFilePath)) {
            $output->writeln('CSV file not found.');
            return Command::FAILURE;
        }

        $csvData = array_map('str_getcsv', file($csvFilePath));
        $header = array_shift($csvData); // Extract the header row

        foreach ($csvData as $row) {
            $dataObject = $this->createDataObject($header, $row);
            $dataObject->save();
            $output->writeln('Created new Csvparse data object with ID: ' . $dataObject->getId());
        }

        $output->writeln('CSV data imported successfully.');
        return Command::SUCCESS;
    }


    protected function createDataObject(array $header, array $rowData)
    {
        $dataObject = new Csvparse();
        $dataObject->setKey('csvdata');
        $dataObject->setParentId(50);

        $classDefinition = ClassDefinition::getByName('Csvparse');
        $fieldMap = [];
        $fieldsColumnNames = [];
        $csvBrickColumnNames = [];

        foreach ($header as $index => $columnName) {
            $value = $rowData[$index];
            $columnName = trim($columnName);

            if (strpos($columnName, 'fields') === 0) {
                $fieldsColumnNames[] = $columnName;
            } else {
                $fieldDefinition = $classDefinition->getFieldDefinition($columnName);

                if ($fieldDefinition) {
                    $setterMethod = 'set' . ucfirst($columnName);
                    $fieldMap[$columnName] = $setterMethod;

                    if (method_exists($dataObject, $setterMethod)) {
                        // echo "Field Type: " . $fieldDefinition->getFieldtype() . PHP_EOL;
                        $this->handleField($fieldDefinition, $value, $dataObject, $setterMethod);
                    }

                }
            }
        }
        $this->processFieldsColumnNames($fieldsColumnNames, $header, $rowData, $dataObject);

        $dataObject->setPublished(true);
        return $dataObject;
    }

    protected function handleField($fieldDefinition, $value, $dataObject, $setterMethod)
    {

        if ($fieldDefinition) {
            $fieldType = $fieldDefinition->getFieldtype();
            // echo "all fields => " . $fieldType . "\n";

            switch ($fieldType) {
                case 'input':
                    $this->handleInputField($value, $dataObject, $setterMethod);
                    break;
                case 'textarea':
                    $this->handleTextareaField($value, $dataObject, $setterMethod);
                    break;
                case 'date':
                    $this->handleDateField($value, $dataObject, $setterMethod);
                    break;
                case 'wysiwyg':
                    $this->handleWysiwygField($value, $dataObject, $setterMethod);
                    break;
                case 'password':
                    $this->handlePasswordField($value, $dataObject, $setterMethod);
                    break;
                case 'numeric':
                    $this->handleNumberField($value, $dataObject, $setterMethod);
                    break;
                // case 'numericRange':
                //     echo "in numeric range ";
                //     $this->handleNumericRangeField($value, $dataObject, $setterMethod);
                //     break;
                // case 'select':
                //     // echo "in select ";

                //     $this->handleSelectField($value, $dataObject, $setterMethod);
                //     break;
                // case 'time':
                //     // echo "in time ";

                //     $this->handleTimeField($value, $dataObject, $setterMethod);
                //     break;
                // case 'booleanSelect':
                //     // echo "in boolselect ";

                //     $this->handleBooleanSelectField($value, $dataObject, $setterMethod);
                //     break;
                // case 'user':
                //     // echo "in user ";

                //     $this->handleUserField($value, $dataObject, $setterMethod);
                //     break;
                // case 'country':
                //     // echo "in country ";

                //     $this->handleCountryField($value, $dataObject, $setterMethod);
                //     break;
                // case 'language':
                //     // echo "in languaghe ";
                //     $this->handleLanguageField($value, $dataObject, $setterMethod);
                //     break;
                case 'manyToOneRelation':
                    // echo "coming in to relation";
                    $this->handleManyToOneField($value, $dataObject, $setterMethod);
                    break;
                case 'image':
                    $this->handleImageField($value, $dataObject, $setterMethod);
                    break;
                case 'manyToManyRelation':
                    // echo "mamy ri mayny " . "\n";
                    $this->handleManyToManyField($value, $dataObject, $setterMethod);
                    break;
                case 'manyToManyObjectRelation':
                    echo "coming in new mtmo relation " . "\n";
                    $this->handleManyToManyObjectRelationField($value, $dataObject, $setterMethod);
                    break;
                case 'advancedManyToManyRelation':
                    echo "coming in new advanced many to many relation " . "\n";
                    $this->handleAdvancedManyToManyRelationField($value, $dataObject, $setterMethod);
                    break;
            }

        }
    }


    private function handleManyToManyObjectRelationField($value, $dataObject, $setterMethod)
    {
        // Assuming $value contains the names of related objects separated by a delimiter (e.g., comma)
        $relatedObjectNames = explode(',', $value);
        $relatedObjects = [];

        // foreach ($relatedObjectNames as $objectName) {
        //     // Fetch related objects based on names
        //     $relatedObject = $relatedObjectClass::getByName($objectName);

        //     if ($relatedObject instanceof $relatedObjectClass) {
        //         $relatedObjects[] = $relatedObject;
        //     }
        // }

        // Set the many-to-many object relation using the setter method
        $dataObject->$setterMethod($relatedObjects);

    }
    private function handleAdvancedManyToManyRelationField($value, $dataObject, $setterMethod)
    {

    }


    // private function handleNumericRangeField($value, $dataObject, $setterMethod)

    // {
    //     $rangeValues = explode('-', $value);

    //     if (count($rangeValues) == 2) {
    //         $minValue = trim($rangeValues[0]);
    //         $maxValue = trim($rangeValues[1]);
    //         $dataObject->$setterMethod(['min' => $minValue, 'max' => $maxValue]);
    //     } else {
    //         $dataObject->$setterMethod(['min' => 0, 'max' => 0]);
    //     }

    // }


    private function handleImageField($value, $dataObject, $setterMethod)
    {
        // $dataObject->$setterMethod($value);
        // Assuming $value is the image path or URL

        if (filter_var($value, FILTER_VALIDATE_URL) || file_exists($value)) {
            // Valid image path or URL
            $dataObject->$setterMethod($value);
        } else {
            // Invalid image path or URL, handle error or log it
            // For now, just set a default value or handle the error in a way that makes sense for your application
            $dataObject->$setterMethod(null);
        }

    }

    private function handleManyToManyField($value, $dataObject, $setterMethod)
    {

        // Assuming $value is an array of paths to the assets for the Many-to-Many relation
        $assets = $this->getAssetsByPaths(explode(',', $value));

        // Assuming $assets is an array of \Pimcore\Model\Asset\Image instances
        $dataObject->$setterMethod($assets);

    }
    private function getAssetsByPaths(array $paths)
    {
        $assets = [];

        foreach ($paths as $path) {
            $asset = $this->getAssetByPath($path);

            if ($asset instanceof \Pimcore\Model\Asset\Image) {
                $assets[] = $asset;
            }
        }

        return $assets;
    }

    private function handleManyToOneField($value, $dataObject, $setterMethod)
    {

        $asset = $this->getAssetByPath($value);

        if ($asset instanceof \Pimcore\Model\Asset\Image) {
            $dataObject->$setterMethod($asset);
        } else {
            $dataObject->$setterMethod(null);
        }
    }


    private function getAssetByPath($path)
    {
        // Implement logic to retrieve the asset based on the path
        // This could involve querying the database, fetching from a service, etc.

        // Example: Fetching an asset by path from the Pimcore assets
        return \Pimcore\Model\Asset\Image::getByPath($path);
    }

    private function handleInputField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod($value);
    }

    private function handleTextareaField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod($value);
    }

    private function handleDateField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod(\Carbon\Carbon::parse($value));
    }

    private function handleWysiwygField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod($value);
    }

    private function handlePasswordField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod($value);
    }

    private function handleNumberField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod($value);
    }



    private function handleSelectField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod($value);
    }

    private function handleTimeField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod($value);
    }

    private function handleBooleanSelectField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod($value);
    }

    private function handleUserField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod($value);
    }

    private function handleCountryField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod($value);
    }

    private function handleLanguageField($value, $dataObject, $setterMethod)
    {
        $dataObject->$setterMethod($value);
    }

    // private function handleImageField($value, $dataObject, $setterMethod)
    // {
    //     // $dataObject->$setterMethod($value);
    //     // Assuming $value is the image path or URL

    //     if (filter_var($value, FILTER_VALIDATE_URL) || file_exists($value)) {
    //         // Valid image path or URL
    //         $dataObject->$setterMethod($value);
    //     } else {
    //         // Invalid image path or URL, handle error or log it
    //         // For now, just set a default value or handle the error in a way that makes sense for your application
    //         $dataObject->$setterMethod(null);
    //     }

    // }

    protected function processFieldsColumnNames(array $fieldsColumnNames, array $header, array $rowData, \Pimcore\Model\DataObject $dataObject)
    {
        $fieldCollection = $dataObject->getFields();
        if (!$fieldCollection) {
            $fieldCollection = new \Pimcore\Model\DataObject\Fieldcollection();
            $fieldCollectionItem = new \Pimcore\Model\DataObject\Fieldcollection\Data\Csvtest();
        }

        foreach ($fieldsColumnNames as $columnName) {
            $columnValuePairs = explode('_', $columnName);
            $fieldCollectionItem->{'set' . ucfirst($columnValuePairs[1])}($rowData[array_search($columnName, $header)]);
        }

        if ($fieldCollectionItem instanceof \Pimcore\Model\DataObject\Fieldcollection\Data\Csvtest) {
            $fieldCollection->add($fieldCollectionItem);
            $dataObject->setFields($fieldCollection);
        }
    }


}

// private function handleImageField($value, $dataObject, $setterMethod)
// {
//     // Assuming $value is the path or URL to the image
//     // You should adjust this logic based on your actual data structure

//     $asset = $this->createImageAsset($value);

//     if ($asset instanceof Pimcore\Model\Asset\Image) {
//         $dataObject->$setterMethod($asset);
//     } else {
//         // Handle the case where the image asset couldn't be created
//         // For now, set a default value or handle the error in a way that makes sense for your application
//         $dataObject->$setterMethod(null);
//     }
// }

// private function createImageAsset($value)
// {
//     // Your logic for creating an image asset from the path or URL
//     // This could involve checking if the image exists, creating a new asset, etc.

//     // Example: Create an image asset from a file path
//     $imageAsset = new Pimcore\Model\Asset\Image();
//     $imageAsset->setData(file_get_contents($value)); // Adjust this based on your actual logic

//     return $imageAsset;
// }
