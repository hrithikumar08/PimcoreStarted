<?php


namespace Codilar\MagentoConnectorBundle\Service;

use Symfony\Component\HttpFoundation\Request;

class ApiService
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function authenticate(Request $request): bool
    {
        $apiKeyHeader = $request->headers->get('actual-key');

        return $apiKeyHeader === $this->apiKey;
    }
}

