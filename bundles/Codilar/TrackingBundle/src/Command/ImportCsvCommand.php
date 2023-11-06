<?php

namespace Codilar\TrackingBundle\Command;

use Symfony\Component\Console\Command\Command;
// use Carbon\Carbon;
use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\Csvparse;
use Pimcore\Model\DataObject\Data;
use Pimcore\Console\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\PropertyAccess\PropertyAccess;

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
            // var_dump($header);
            // var_dump($row);

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
    
        foreach ($header as $index => $columnName) {
            $value = $rowData[$index];

            // var_dump($dataObject);
            // var_dump($columnName);

            // var_dump($classDefinition->getFieldDefinition($columnName));

            if ($classDefinition->getFieldDefinition($columnName)) {

                $setterMethod = 'set' . ucfirst($columnName);
                $fieldMap[$columnName] = $setterMethod;

                print_r($fieldMap);
    
                if (method_exists($dataObject, $setterMethod)) {

                    // var_dump($setterMethod);
                    // Check for date field and convert if necessary

                    if ($setterMethod === 'setItemLaunched') {

                        $value = \Carbon\Carbon::parse($value);

                    } elseif ($setterMethod === 'setBlock') {

                        // Handle block field

                        echo "coming in block ";

                        $blockData = json_decode($value, true);
                        if (is_array($blockData)) {
                            $blocks = [];
                            foreach ($blockData as $blockDatum) {
                                // Create a new block instance
                                $blockObject = new Csvparse();
    
                                // Loop through the subfields of the block and assign values dynamically
                                foreach ($blockDatum as $subField => $subValue) {
                                    var_dump($subField);
                                    var_dump($subValue);
                                    // Construct the setter method for the subfield
                                    $subSetterMethod = 'set' . ucfirst($subField);
                                    if (method_exists($blockObject, $subSetterMethod)) {
                                        $blockObject->$subSetterMethod($subValue);
                                    }
                                }
    
                                $blocks[] = $blockObject;
                            }
                            $dataObject->$setterMethod($blocks);
                        }

                    } elseif ($setterMethod === 'setFields') {

                        // Handle field collection

                        // $fieldCollectionData = json_decode($value, true);
                        // if (is_array($fieldCollectionData)) {
                        //     $fieldCollection = new \Pimcore\Model\DataObject\Fieldcollection();
                        //     foreach ($fieldCollectionData as $fieldData) {
                        //         // Create a new field collection item
                        //         $fieldCollectionItem = new \Pimcore\Model\DataObject\Fieldcollection\Data\FieldcollectionDataObject();
                        //         foreach ($fieldData as $subField => $subValue) {
                        //             // Construct the setter method for the subfield
                        //             $subSetterMethod = 'set' . ucfirst($subField);
                        //             if (method_exists($fieldCollectionItem, $subSetterMethod)) {
                        //                 $fieldCollectionItem->$subSetterMethod($subValue);
                        //             }
                        //         }
                        //         $fieldCollection->add($fieldCollectionItem);
                        //     }
                        //     $dataObject->$setterMethod($fieldCollection);
                        // }

                    } else {
                        $dataObject->$setterMethod($value);
                    }
                }
            }
        }
    
        $dataObject->setPublished(true);
        return $dataObject;
    }
    



    // protected function createDataObject(array $header, array $rowData)
    // {
    //     $dataObject = new Csvparse();
    //     $dataObject->setKey('csvdata');
    //     $dataObject->setParentId(50);
    
    //     $classDefinition = ClassDefinition::getByName('Csvparse');
    //     $fieldMap = [];
    
    //     foreach ($header as $index => $columnName) {
    //         $value = $rowData[$index];

    //         var_dump($value);
    //         var_dump($index);
    //         var_dump($columnName);
    
    //         if ($classDefinition->getFieldDefinition($columnName)) {
    //             $setterMethod = 'set' . ucfirst($columnName);
    //             $fieldMap[$columnName] = $setterMethod;
    
    //             if (method_exists($dataObject, $setterMethod)) {
    //                 // Check for date field and convert if necessary
    //                 if ($setterMethod === 'setItemLaunched') {
    //                     $value = \Carbon\Carbon::parse($value);
    //                 }
    
    //                 $dataObject->$setterMethod($value);
    //             }
    //         }
    //     }
    
    //     $dataObject->setPublished(true);
    //     return $dataObject;
    // }




}

