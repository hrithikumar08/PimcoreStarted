<?php

namespace App\Model\DataObject;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Concrete;
class BlockParent extends Concrete
{
    public function getDescription()
    {
        return "This is a block parent description";
    }
}