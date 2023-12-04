<?php
namespace Codilar\MagentoConnectorBundle\EventListener;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Event\Model\DataObject\ClassDefinition;

class DataObjectEventListener
{
    public function onPostUpdate(DataObjectEvent $event)
    {
        /** @var \Pimcore\Model\DataObject\Blockclass $dataObject */
        $dataObject = $event->getObject();

        if ($dataObject instanceof \Pimcore\Model\DataObject\Blockclass && $dataObject->isPublished()) {
            $objectId = $dataObject->getId();

            $httpClient = HttpClient::create();
            $response = $httpClient->request('POST', 'https://codilar-pimcore-test.free.beeceptor.com/dataobjects/test', [
                'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
                'body' => ['objectId' => $objectId, 'Name' => "Hrithik"],
            ]);

            $statusCode = $response->getStatusCode();
            $content = $response->getContent();

        }
    }
}
