<?php

namespace DarKsandr\Images\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use DarKsandr\Images\Components\ImageComponent;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/images.php' => config_path('images.php'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'images');

        Blade::component(config('images.component'), ImageComponent::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/images.php', 'images'
        );
    }
}