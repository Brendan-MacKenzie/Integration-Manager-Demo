<?php

namespace App\Http\Controllers;

use App\Services\ExactOnlineService;
use App\Services\MrEinsteinService;
use BrendanMacKenzie\IntegrationManager\Flows\OAuthAuthorizationCodeFlow;
use BrendanMacKenzie\IntegrationManager\Models\Integration;
use BrendanMacKenzie\IntegrationManager\Utils\ApiClient;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function clientCredentialTest()
    {
        $integration = Integration::where('integration_option_id', 1)->first();
        $service = new MrEinsteinService($integration);
        $data = $service->getClientInfo();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function authorizationTest()
    {
        $integration = Integration::where('integration_option_id', 2)->first();
        $service = new ExactOnlineService($integration);
        $data = $service->getMe();

        if (is_string($data)) {
            return redirect($data);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function authorizationRedirect(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'code' => 'required|string',
        ]);

        // Get the right integration for the request, usually you can get the integration via the Authenticated user.
        $integration = Integration::where('integration_option_id', 2)->first();
        
        // Build the API Client and OAuth Authorization flow for the selected integration
        $apiClient = new ApiClient();
        $apiClient->setBaseUrl($integration->base_url);
        $apiClient->setAuthUrl($integration->auth_url);

        $oAuthAuthorizationFlow = new OAuthAuthorizationCodeFlow(
            $integration,
            $apiClient,
            false,                  // Set this to true if you want to enable a state check for the authorization request.
            true,                   // Set this to true if you want to set the body attributes to form_params instead of a JSON body.
            true                    // Set this to true if you want to use the auth_url attribute as the base_url for the access token request. Set to false if you want to use the base_url for the access token request.
        );

        // Process the redirected request with the provided authorization code.
        try {
            $oAuthAuthorizationFlow->processRedirect($request);
        } catch (Exception $exception) {
            throw $exception;
        }

        return redirect('/authorization');
    } 
}
