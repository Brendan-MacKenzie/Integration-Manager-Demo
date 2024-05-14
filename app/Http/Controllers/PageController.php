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
            false,
            true
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
