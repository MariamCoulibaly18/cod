<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //define gates
        Gate::define('is-admin', function($user){
            return $user->type == 'admin' || $user->type == 'super_admin';
        });

        //is-super-admin
        Gate::define('is-super-admin', function($user){
            return $user->type == 'super_admin';
        });

        //is responsible for boutique
        Gate::define('is-responsible', function($user, $boutique){
            return  ($user->type =='admin' && $user->id == $boutique->user_id); 
        });

        //is livreur
        Gate::define('is-livreur', function($user){
            return  $user->type == 'livreur'; 
        });

        //is boutique local
        Gate::define('is-boutique-local', function($boutique){
            return  $boutique->type == 'local'; 
        });

        //is boutique woocommerce
        Gate::define('is-boutique-woocommerce', function($boutique){
            return  $boutique->type == 'woocommerce'; 
        });

        //is boutique prestashop
        /*Gate::define('is-boutique-prestashop', function($boutique){
            return  $boutique->type == 'prestashop'; 
        });

        //is boutique shopify
        Gate::define('is-boutique-shopify', function($boutique){
            return  $boutique->type == 'shopify'; 
        });*/

        //token expiration
        Passport::tokensExpireIn(now()->addDays(1));
        //passport routes
        Passport::routes();
    }
}
