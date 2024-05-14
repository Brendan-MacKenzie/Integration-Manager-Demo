<?php

namespace App\Services;

use BrendanMacKenzie\IntegrationManager\Flows\OAuthClientCredentialFlow;
use BrendanMacKenzie\IntegrationManager\Utils\ApiClient;
use BrendanMacKenzie\IntegrationManager\Models\Integration;
use BrendanMacKenzie\IntegrationManager\Utils\IntegrationService;

class MrEinsteinService extends IntegrationService
{
    /** @var Integration */
    public $integration;

    /** @var ApiClient */
    private $apiClient;

    public $defaultHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    public function __construct(
        Integration $integration
    ) {
        $this->integration = $integration;
        $this->apiClient = new ApiClient();
        parent::__construct($this->apiClient);
    }

    public function authenticate(): void
    {
        $oAuthClientCredentialFlow = new OAuthClientCredentialFlow(
            $this->integration,
            $this->apiClient
        );

        $oAuthClientCredentialFlow->authenticate();
    }

    public function getClientInfo()
    {
        return $this->call('GET', '/client/app/'.$this->integration->getCredential('client_id'));
    }
}
