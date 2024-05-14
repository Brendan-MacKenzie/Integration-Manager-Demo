<?php

namespace App\Services;

use BrendanMacKenzie\IntegrationManager\Flows\OAuthAuthorizationCodeFlow;
use BrendanMacKenzie\IntegrationManager\Utils\ApiClient;
use BrendanMacKenzie\IntegrationManager\Models\Integration;
use BrendanMacKenzie\IntegrationManager\Utils\IntegrationService;
use GuzzleHttp\Psr7\Response;

class ExactOnlineService extends IntegrationService
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

    public function authenticate()
    {
        $oAuthAuthorizationFlow = new OAuthAuthorizationCodeFlow(
            $this->integration,
            $this->apiClient,
            true
        );

        $authorizationUrl = $oAuthAuthorizationFlow->authenticate();
        if ($authorizationUrl) {
            return $authorizationUrl;
        }
    }

    public function getMe()
    {
        return $this->call('GET', '/me');
    }
}
