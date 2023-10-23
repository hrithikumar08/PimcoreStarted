<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MyService implements ContainerAwareInterface
{
    private $container;
    // private $debug = false;

    public function setContainer(ContainerInterface $container = null)
    {
        // if ($this->debug) {
        //     $debug('MyService setContainer() called');
        // }
        
        $this->container = $container;
    }

    public function doSomething()
    {
        // if ($this->debug) {
        //     $debug('MyService doSomething() called');
        // }

        // Get the current user
        // $user = $this->container->get('pimcore.user.service')->getCurrentUser();

        // // Log a message to the Pimcore log
        // $this->container->get('monolog.logger')->info(sprintf('User "%s" called the "doSomething()" method on the "MyService" service.', $user->getUsername()));

        // $this->container->get('monolog.logger')->info('MyService doSomething() called');
        // return "working";
    }
}
