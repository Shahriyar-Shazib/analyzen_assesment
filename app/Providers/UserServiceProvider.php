<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserServiceInterface;
use App\Services\UserService;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        UserAddressSaved::class => [
            SaveUserAddresses::class,
        ],
    ];
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
