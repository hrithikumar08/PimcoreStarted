<?php

namespace App\EventListener;

use Pimcore\Model\DataObject\Product;
use Pimcore\Bundle\AdminBundle\Event\ElementAdminStyleEvent;
class AdminStyleListener
{
    // public function onResolveElementAdminStyle(ElementAdminStyleEvent $event): void
    // {
    //     $element = $event->getElement();
    //     // decide which default styles you want to override
    //     if ($element instanceof Product) {
    //         $event->setAdminStyle(new Product($element));
    //     }
    // }
}
