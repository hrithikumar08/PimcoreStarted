<?php

namespace App\Model\Product;

interface TransmissionInterface
{
    public function getSku(): ?string;

    public function getName(): ?string;
}