<?php

namespace App\Model\DataObject;

use Pimcore\Model\DataObject;

class ParentNews extends DataObject
{
    // Define the common fields and behaviors for all news objects here
    public function getTitle()
    {
        return "This is a parent news title";
    }
}