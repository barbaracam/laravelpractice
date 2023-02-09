<?php

namespace App\Providers;

//uncomment the gate below
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */

     //come from PostPolicy.php
    protected $policies = [
        Post::class =>PostPolicy::class
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',


    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

     //we do a gate here
    public function boot()
    {
        $this->registerPolicies();

        //define our personal gate
        Gate::define('visitAdminPages', function($user){
                return $user->isAdmin === 1;
        });

    }
}
