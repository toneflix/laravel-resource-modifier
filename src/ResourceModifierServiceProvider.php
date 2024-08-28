<?php

namespace ToneflixCode\ResourceModifier;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @method \Illuminate\Support\Stringable replace(string|iterable $search, string|iterable $replace, $caseSensitive = true)
 * @method string toString()
 */
class ResourceModifierServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('resource-modifier.php'),
            ], 'resource-modifier');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'resource-modifier');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-resource-modifier', function () {
            return new ResourceModifier();
        });
    }
}