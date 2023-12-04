<?php

namespace Codilar\MagentoConnectorBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\PimcoreBundleAdminClassicInterface;
use Pimcore\Extension\Bundle\Traits\BundleAdminClassicTrait;
use Codilar\MagentoConnectorBundle\Tool\Installer;

class CodilarMagentoConnectorBundle extends AbstractPimcoreBundle implements PimcoreBundleAdminClassicInterface
{
    use BundleAdminClassicTrait;

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getJsPaths(): array
    {
        return [
            'bundles/codilarmagentoconnector/js/pimcore/startup.js'
        ];
    }
    public function getInstaller():Installer
    {
        return $this->container->get(Installer::class);
    }

}