<?php

namespace App\Providers;

use App\AuthProvider\EmployeeAuthProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider('employees-api', function (Application $app, array $config) {
            return new EmployeeAuthProvider();
        });
    }
}
