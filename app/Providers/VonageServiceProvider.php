<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;

class VonageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // // Register your custom function here
        // $this->app->bind('vonage', function ($app) {
        //     $apiKey = config('services.vonage.api_key');
        //     return new Client($apiKey);
        // });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
