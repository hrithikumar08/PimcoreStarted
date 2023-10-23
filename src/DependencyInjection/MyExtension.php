<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use App\Service\MyService;

class MyExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        // Define your services here
        $container->register('my_service', MyService::class);
    }

}