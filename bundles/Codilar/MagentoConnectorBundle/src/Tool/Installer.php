<?php
namespace Codilar\MagentoConnectorBundle\Tool;

use Pimcore\Extension\Bundle\Installer\AbstractInstaller;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\ClassDefinition\Service;
use Symfony\Component\Config\FileLocator;


class Installer extends AbstractInstaller
{

    const CONFIGURATION_CLASS_NAME = 'Csvparse';

    public function install(): void
    {

        if ($this->isInstalled()) {
            echo "The class is already installed."."\n";
            die();
        }
        
        // print_r(__DIR__ );

        $filePath = __DIR__ . '/../../config/install/class_sources/class_Csvparse_export.json';

        // print_r($filePath);
        $path = realpath($filePath);
        $class = new ClassDefinition();
        $class->setName(self::CONFIGURATION_CLASS_NAME);
        $data = file_get_contents($path);
        $success = Service::importClassDefinitionFromJson($class, $data);

    }

    public function canBeInstalled(): bool
    {
        // return true;
        return !$this->isInstalled();
    }

    public function uninstall(): void
    {

        $class = new ClassDefinition();
        $classDetails = $class->getByName(self::CONFIGURATION_CLASS_NAME);
        if ($classDetails instanceof ClassDefinition) {
            $classDetails->delete();
            
        }
    }

    public function canBeUninstalled(): bool
    {
        return $this->isInstalled();
    }

    public function isInstalled(): bool
    {
        $classDefinition = ClassDefinition::getByName(self::CONFIGURATION_CLASS_NAME);
        return $classDefinition instanceof ClassDefinition;
    }

}