<?php

namespace App\ManualBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\DocumentType;
use Pimcore\Extension\Bundle\PimcoreBundle\DependencyInjection\PimcoreExtension;

class Registration extends AbstractPimcoreBundle
{
    public function getBundleName(): string
    {
        return 'ManualBundle';
    }

    // public function registerDocumentTypes(): array
    // {
    //     return [
    //         new DocumentType('CustomDocument', [
    //             'name' => 'Custom Document',
    //             'description' => 'A custom document type.',
    //             'fields' => [
    //                 [
    //                     'name' => 'title',
    //                     'type' => 'text',
    //                     'required' => true,
    //                 ],
    //             ],
    //         ]),
    //     ];
    // }
    // public function registerBundleTypes(): array
}
