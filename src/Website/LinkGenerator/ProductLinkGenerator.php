<?php

namespace App\Website\LinkGenerator;

use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\Product;

class ProductLinkGenerator implements LinkGeneratorInterface
{
    public function generate(object $object, array $params = []): string
    {
        if (!$object instanceof Product) {
            throw new \InvalidArgumentException('Invalid object type. Expected Product.');
        }

        // Use the SKU and name of the product to generate a URL.
        $sku = $object->getSku();
        $name = $object->getName();

        $slug = $this->generateSlug($sku, $name);

        // Return the generated URL.
        return '/products/' . $slug;
    }

    protected function generateSlug($sku, $name)
    {
        // Implement your custom slug generation logic here.
        // You can combine SKU and name, and make it URL-friendly.

        // Example: "tshirt-abc123-my-awesome-tshirt"
        return strtolower('tshirt/' . $sku . '/'. $name);
        // . Text::toUrl($name)
    }
}
