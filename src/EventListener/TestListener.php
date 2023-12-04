<?php

namespace App\EventListener;
  
use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Event\Model\AssetEvent;
use Pimcore\Event\Model\DocumentEvent;

class TestListener
{
    public function onPreUpdate(ElementEventInterface $e): void
    {
        // if ($e instanceof AssetEvent) {
        //     // do something with the asset
        //     $foo = $e->getAsset(); 
        // } else if ($e instanceof DocumentEvent) {
        //     // do something with the document
        //     $foo = $e->getDocument(); 
        // } else if ($e instanceof DataObjectEvent) {
        //     // do something with the object
        //     $foo = $e->getObject(); 
        //     $foo->setMyValue(microtime(true));
        //     // we don't have to call save here as we are in the pre-update event anyway ;-) 
        // }
    }
}