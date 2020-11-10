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
         *
         * @param $set
         */
        public function __construct($set = 'pay')
        {
            $api_url       = config('tranzzo.api_url');
            $endpoints_key = config('tranzzo.endpoints_key');

            $pos_id       = config('tranzzo.' . $set . '.pos_id');
            $api_key      = config('tranzzo.' . $set . '.api_key');
            $api_secret   = config('tranzzo.' . $set . '.api_secret');

            $this->client = new AbstractTranzzo($api_url, $pos_id, $api_key, $api_secret, $endpoints_key);
        }

        /**
         * Issuing a loan to a client
         *
         * @param array $fields
         *
         * @return mixed
         */
        public function credit2client($fields = [])
        {
            $this->client->setParams($fields);
            $data = $this->client->createCreditPayment();
            return json_encode($data, TRUE);
        }

        /**
         * Direct payment
         *
         * @param       $type_payment
         * @param array $fields
         *
         * @return mixed
         */
        public function client2merchant($type_payment, $fields = [])
        {
            $this->client->setParams($fields);
            $data = $this->client->createPaymentDirect($type_payment);
            return json_encode($data, TRUE);
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
