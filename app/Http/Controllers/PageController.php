<?php

namespace App\Http\Controllers;

use App\Services\ExactOnlineService;
use App\Services\MrEinsteinService;
use BrendanMacKenzie\IntegrationManager\Models\Integration;
use GuzzleHttp\Psr7\Response;

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

        if (!$data instanceof Response) {
            return redirect($data);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
