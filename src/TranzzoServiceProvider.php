<?php

    namespace Vt2\LaravelTranzzo;

    use Illuminate\Support\ServiceProvider;

    /**
     * Class TranzzoServiceProvider
     * @package Vt2\LaravelTranzzo
     */
    class TranzzoServiceProvider extends ServiceProvider
    {
        /**
         * Bootstrap the application services.
         */
        public function boot()
        {
            $this->publishes([
                __DIR__ . '/../config/tranzzo.php' => config_path('tranzzo.php'),
            ], 'config');

            // Publishing is only necessary when using the CLI.
            if ($this->app->runningInConsole()) {
                $this->bootForConsole();
            }
        }

        /**
         * Register the application services.
         */
        public function register()
        {
            $this->mergeConfigFrom(__DIR__ . '/../config/tranzzo.php', 'tranzzo');

            // Register the service the package provides.
            $this->app->singleton('laravelTranzzo', function ($app) {
                return new Tranzzo;
            });
        }

        /**
         * Get the services provided by the provider.
         *
         * @return array
         */
        public function provides()
        {
            return ['laravelTranzzo'];
        }

        /**
         * Console-specific booting.
         *
         * @return void
         */
        protected function bootForConsole()
        {
            // Publishing the configuration file.
            $this->publishes([
                __DIR__ . '/../config/tranzzo.php' => config_path('tranzzo.php'),
            ], 'config');
        }
    }

