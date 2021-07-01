<?php

namespace App\Providers;

use App\Services\ImageStorageService;
use App\Services\StorageService;
use Faker\Provider\Image;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StorageService::class, function ($app) {
            return new ImageStorageService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
