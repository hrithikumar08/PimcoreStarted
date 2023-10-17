<?php

namespace App\Model\DataObject;

use App\Model\DataObject\ParentNews;

class ChildNews extends ParentNews
{
    // Add any custom fields and behaviors for the News object class here
    public function getTitle()
    {
        return "This is a child news title";
    }
    
}