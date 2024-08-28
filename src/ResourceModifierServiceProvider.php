<?php

namespace ToneflixCode\ResourceModifier;

use Illuminate\Support\ServiceProvider;
use ToneflixCode\ResourceModifier\Commands\ResourceMakeCommand;

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
                __DIR__.'/../config/config.php' => config_path('resource-modifier.php'),
            ], 'resource-modifier');

            $this->commands([
                ResourceMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'resource-modifier');
    }
}
