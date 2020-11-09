<?php

    namespace Vt2\LaravelTranzzo;

    use Vt2\LaravelTranzzo\Support\TranzzoApi as AbstractTranzzo;
    use Illuminate\Support\Facades\Config;

    /**
     * Class Tranzzo
     * @package Vt2\LaravelTranzzo
     */
    class Tranzzo
    {

        protected $client = null;

        /**
         * Tranzzo constructor.
         */
        public function __construct()
        {
            $api_url       = config('tranzzo.api_url');
            $pos_id        = config('tranzzo.pos_id');
            $api_key       = config('tranzzo.api_key');
            $api_secret    = config('tranzzo.api_secret');
            $endpoints_key = config('tranzzo.endpoints_key');

            $this->client = new AbstractTranzzo($api_url, $pos_id, $api_key, $api_secret, $endpoints_key);
        }

        /**
         * test
         */
        public function test()
        {
            $data = $this->client->checkStatus();
            return json_encode($data, TRUE);
        }


    }
