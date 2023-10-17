<?php

namespace App\EventListener;

use Pimcore\Bundle\AdminBundle\Event\Product\PrePersistEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ProductEventListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            //run after Symfony\Component\HttpKernel\EventListener\SessionListener
            KernelEvents::REQUEST => ['onKernelRequest', 127],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {

        if (!$event->isMainRequest()) {
            return;
        }

        $session = $event->getRequest()->getSession();

        if (!$session->isStarted()) {
            $session->set('complaintus', 100);
        }

       
    }
}

 // if (!$event->isMainRequest()) {
        //     return;
        // }
        
        // if ($event->getRequest()->attributes->get('_stateless', false)) {
        //     return;
        // }

        // $session = $event->getRequest()->getSession();
        
        // //do not register bags, if session is already started
        // if ($session->isStarted()) {
        //     return;
        // }

        // $bag = new AttributeBag('_session_cart');
        // $bag->setName('session_cart');
 
        // $session->registerBag($bag);



// class ProductEventListener implements EventSubscriberInterface
// {
//     public static function getSubscribedEvents(): array
//     {
//         return [
//             PrePersistEvent::class => ['onPrePersistProduct'],
//         ];
//     }

//     public function onPrePersistProduct(PrePersistEvent $event): void
//     {
//         $product = $event->getProduct();

//         // Set the custom name
//         $product->setName('My Custom Product Name');

//         // Set the custom ID
//         $product->setId(1000);
//     }
// }
