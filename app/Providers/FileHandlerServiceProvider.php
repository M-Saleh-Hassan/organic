<?php

namespace App\Providers;

use App\Services\FileHandler\FileHandlerInterface;
use App\Services\FileHandler\LocalFileHandler;
use Illuminate\Support\ServiceProvider;

class FileHandlerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FileHandlerInterface::class, function ($app){
            return new LocalFileHandler();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
