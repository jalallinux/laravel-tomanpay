<?php

namespace JalalLinuX\Tomanpay;

use Illuminate\Support\ServiceProvider;

class TomanpayServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tomanpay.php', 'tomanpay');
    }

    public function boot(): void
    {
        $this->registerCommands();
        $this->registerPublishing();
        $this->registerBindings();
        $this->registerTranslations();
    }

    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/tomanpay.php' => config_path('tomanpay.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../lang' => lang_path('vendor/laravel-tomanpay'),
            ], 'lang');
        }
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }

    public function registerBindings(): void
    {
        /** Register Helper function class */
        $this->app->singleton(Tomanpay::class);
    }

    public function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'tomanpay');
    }
}
