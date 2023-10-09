<?php

namespace App\Traits;

trait TransmissionTrait
{
    public function getSku(): ?string
    {
        return "Example SKU";
    }

    public function getName(): ?string
    {
        return "Name with Interface";
    }
}