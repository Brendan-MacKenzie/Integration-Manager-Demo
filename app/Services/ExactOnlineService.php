<?php

namespace App\Services;

use BrendanMacKenzie\IntegrationManager\Flows\OAuthAuthorizationCodeFlow;
use BrendanMacKenzie\IntegrationManager\Utils\ApiClient;
use BrendanMacKenzie\IntegrationManager\Models\Integration;
use BrendanMacKenzie\IntegrationManager\Utils\IntegrationService;

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
            false,                  // Set this to true if you want to enable a state check for the authorization request.
            true,                   // Set this to true if you want to set the body attributes to form_params instead of a JSON body.
            true                    // Set this to true if you want to use the auth_url attribute as the base_url for the access token request. Set to false if you want to use the base_url for the access token request.
        );

        $authorizationUrl = $oAuthAuthorizationFlow->authenticate();
        if ($authorizationUrl) {
            return $authorizationUrl;
        }
    }

    public function getMe()
    {
        return $this->call('GET', '/api/v1/current/Me');
    }
}
