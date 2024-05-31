<?php

namespace Database\Seeders;

use App\Models\User;
use BrendanMacKenzie\IntegrationManager\Models\Integration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'Wouter',
            'email' => 'wouter@brendan-mackenzie.com'
        ], [
            'password' => password_hash(Str::random(16), PASSWORD_BCRYPT),
        ]);

        $user = User::where('email', 'wouter@brendan-mackenzie.com')->first();

        // Make integration for Client Credential flow
        $integration = Integration::create([
            'integration_option_id' => 1,
            'base_url' => 'https://www.einstein.brenzie.nl/',
            'authentication_endpoint' => '/oauth/token',
        ]);

        $credentials = [
            'client_id' => config('app.INTEGRATION_KEY_1'),
            'client_secret' => config('app.INTEGRATION_SECRET_1'),
        ];

        $integration->owner()->associate($user);
        $integration->setCredentials($credentials);

        // Make integration for Authorization flow
        $integration = Integration::create([
            'integration_option_id' => 2,
            'base_url' => 'https://start.exactonline.nl/',
            'auth_url' => 'https://start.exactonline.nl/',
            'authorization_url' => 'https://start.exactonline.nl/api/oauth2/auth',
            'authentication_endpoint' => '/api/oauth2/token',
        ]);

        $credentials = [
            'client_id' => config('app.INTEGRATION_KEY_2'),
            'client_secret' => config('app.INTEGRATION_SECRET_2'),
        ];

        $integration->owner()->associate($user);
        $integration->setCredentials($credentials);
    }
}
