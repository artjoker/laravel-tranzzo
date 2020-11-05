<?php

    namespace Vt2\LaravelTranzzo\Facades;

    use Illuminate\Support\Facades\Facade;

    /**
     * Class Tranzzo
     * @package Vt2\LaravelTranzzo\Facades
     */
    class Tranzzo extends Facade
    {
        /**
         * Get the registered name of the component.
         *
         * @return string
         */
        protected static function getFacadeAccessor(): string
        {
            return 'Tranzzo';
        }
    }
