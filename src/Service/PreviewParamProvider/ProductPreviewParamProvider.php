<?php

namespace App\Service\PreviewParamProvider;

use App\Website\LinkGenerator\ProductLinkGenerator;
use Pimcore\Model\DataObject\ClassDefinition\PreviewGeneratorInterface;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\ClassDefinition\Data;

class ProductPreviewParamProvider implements PreviewGeneratorInterface
{
    // protected ProductLinkGenerator $productLinkGenerator;

    // public function __construct(ProductLinkGenerator $productLinkGenerator)
    // {
    //     $this->productLinkGenerator = $productLinkGenerator;
    // }

    // public function generatePreviewUrl(Concrete $object, array $params): string
    // {
    //     // Customize this method to generate the preview URL based on your product class fields and parameters.
    //     // Example: Get values from object fields and add them to the additionalParams array.
    //     $additionalParams = [
    //         'sku' => $object->getSku(),
    //         'name' => $object->getName(),
    //     ];

    //     // Merge additional parameters from $params array, if needed.
    //     $additionalParams = array_merge($additionalParams, $params);

    //     // Use the ProductLinkGenerator to generate the URL.
    //     return $this->productLinkGenerator->generate($object, $additionalParams);
    // }

    // public function getPreviewConfig(Concrete $object): array
    // {
    //     // Customize this method to define the preview configuration based on your product class fields.
    //     // Example: Define parameters for preview configuration.
    //     return [
    //         [
    //             'name' => 'sku',
    //             'label' => 'SKU',
    //             // 'type' => Data::TYPE_TEXT,
    //         ],
    //         [
    //             'name' => 'name',
    //             'label' => 'Name',
    //             // 'type' => Data::TYPE_TEXT,
    //         ],
    //         // Add more parameters as needed.
    //     ];
    // }


    protected ProductLinkGenerator $productLinkGenerator;

    public function __construct(ProductLinkGenerator $productLinkGenerator)
    {
        $this->productLinkGenerator = $productLinkGenerator;
    }

    public function generatePreviewUrl(Concrete $object, array $params): string
    {
        $additionalParams = [];
        foreach($this->getPreviewConfig($object) as $paramStore) {
            $paramName = $paramStore['name'];
            if($paramValue = $params[$paramName]) {
                $additionalParams[$paramName] = $paramValue;
            }
        }

        return $this->productLinkGenerator->generate($object, $additionalParams);
    }

    public function getPreviewConfig(Concrete $object): array
    {
        return [
            [
                'name' => '_locale',
                'label' => 'Locale',
                'values' => [
                    'English' => 'en',
                    'German' => 'de'
                ],
                'defaultValue' => 'en'
            ],
            [
                'name' => 'otherParam',
                'label' => 'Other',
                'values' => [
                    'Label Text' => 'value',
                    'Option #2' => 2,
                    'Custom Option' => 'custom'
                ],
                'defaultValue' => 'value'
            ]
        ];
    }
}
