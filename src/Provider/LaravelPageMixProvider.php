<?php

namespace CampaigningBureau\LaravelPageMix\Provider;

use Illuminate\Support\ServiceProvider;
use MScharl\LaravelPageMix\Classes\PageMix;

class LaravelPageMixProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/page-mix.php' => config_path('page-mix.php'),
        ], 'config');

        $this->app->singleton('page-mix', function() {
            return new PageMix($this->app->make('files'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/page-mix.php', 'page-mix');
    }

    public function provides()
    {
        return [
            'page-mix'
        ];
    }
}
