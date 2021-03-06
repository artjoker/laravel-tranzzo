<?php

    namespace Artjoker\LaravelTranzzo\Support;

    use Illuminate\Support\Facades\Log;

    /**
     * Class TranzzoApi
     * @package Artjoker\LaravelTranzzo\Providers
     */
    class TranzzoApi
    {
        /*
         * https://tranzzo.docs.apiary.io/ The Tranzzo API is an HTTP API served by Tranzzo payment core
         */
        //Common params
        const P_MODE_HOSTED          = 'hosted';
        const P_MODE_DIRECT          = 'direct';
        const P_REQ_CPAY_ID          = 'uuid';
        const P_REQ_POS_ID           = 'pos_id';
        const P_REQ_ENDPOINT_KEY     = 'key';
        const P_REQ_MODE             = 'mode';
        const P_REQ_METHOD           = 'method';
        const P_REQ_AMOUNT           = 'amount';
        const P_REQ_CURRENCY         = 'currency';
        const P_REQ_DESCRIPTION      = 'description';
        const P_REQ_ORDER            = 'order_id';
        const P_REQ_PRODUCTS         = 'products';
        const P_REQ_ORDER_3DS_BYPASS = 'order_3ds_bypass';
        const P_REQ_CC_NUMBER        = 'cc_number';
        const P_REQ_PAYWAY           = 'payway';
        //new
        const P_METHOD_PURCHASE = 'purchase';
        const P_METHOD_AUTH     = 'auth';
        const P_METHOD_LOOKUP   = 'lookup';
        const P_METHOD_CAPTURE  = 'capture';
        //new

        const P_OPT_PAYLOAD = 'payload';

        const P_REQ_CUSTOMER_ID    = 'customer_id';
        const P_REQ_CUSTOMER_EMAIL = 'customer_email';
        const P_REQ_CUSTOMER_FNAME = 'customer_fname';
        const P_REQ_CUSTOMER_LNAME = 'customer_lname';
        const P_REQ_CUSTOMER_PHONE = 'customer_phone';

        const P_REQ_SERVER_URL = 'server_url';
        const P_REQ_RESULT_URL = 'result_url';

        const P_REQ_SANDBOX = 'sandbox';

        //Void
        const P_VOID_ORDER = 'order_id';

        //Response params
        const P_RES_PROV_ORDER = 'provider_order_id';
        const P_RES_PAYMENT_ID = 'payment_id';
        const P_RES_TRSACT_ID  = 'transaction_id';
        const P_RES_STATUS     = 'status';
        const P_RES_CODE       = 'code';
        const P_RES_RESP_CODE  = 'response_code';
        const P_RES_RESP_DESC  = 'response_description';
        const P_RES_ORDER      = 'order_id';
        const P_RES_AMOUNT     = 'amount';
        const P_RES_CURRENCY   = 'currency';

        const P_TRZ_ST_SUCCESS      = 'success';
        const P_TRZ_ST_PENDING      = 'pending';
        const P_TRZ_ST_CANCEL       = 'rejected';
        const P_TRZ_ST_UNSUCCESSFUL = 'unsuccessful';
        const P_TRZ_ST_ANTIFRAUD    = 'antifraud';

        //Request method
        const R_METHOD_GET  = 'GET';
        const R_METHOD_POST = 'POST';

        //URI method
        const U_METHOD_PAYMENT = 'payment';
        const U_METHOD_POS     = 'pos';
        const U_METHOD_REFUND  = 'refund';
        //new
        const U_METHOD_CAPTURE = 'capture';
        const U_METHOD_AUTH    = 'auth';
        const U_METHOD_VOID    = 'void';
        //new

        /**
         * @var string
         */
        private $apiUrl = 'https://cpay.tranzzo.com/api/v1';

        /**
         * @var string
         */
        private $posId;

        /**
         * @var string
         */
        private $apiKey;

        /**
         * @var string
         */
        private $apiSecret;

        /**
         * @var string
         */
        private $endpointsKey;

        /**
         * @var array $headers
         */
        private $headers;

        private $params = [];

        /**
         * Ik_Service_Tranzzo_Api constructor.
         *
         * @param $apiUrl
         * @param $posId
         * @param $apiKey
         * @param $apiSecret
         * @param $endpointKey
         */
        public function __construct($apiUrl, $posId, $apiKey, $apiSecret, $endpointKey)
        {
            if (empty($apiUrl) || empty($posId) || empty($apiKey) || empty($apiSecret) || empty($endpointKey)) {
                self::writeLog('Invalid constructor parameters', '', 'error');
            }

            $this->apiUrl       = $apiUrl;
            $this->posId        = $posId;
            $this->apiKey       = $apiKey;
            $this->apiSecret    = $apiSecret;
            $this->endpointsKey = $endpointKey;

        }

        public function setServerUrl($value = '')
        {
            $this->params[self::P_REQ_SERVER_URL] = $value;
        }

        public function setResultUrl($value = '')
        {
            $this->params[self::P_REQ_RESULT_URL] = $value;
        }

        public function setOrderId($value = '')
        {
            $this->params[self::P_REQ_ORDER] = strval($value);
        }

        public function setAmount($value = 0, $round = null)
        {
            $this->params[self::P_REQ_AMOUNT] = self::amountToDouble($value, $round);
        }

        public function setCurrency($value = '')
        {
            $this->params[self::P_REQ_CURRENCY] = $value;
        }

        public function setDescription($value = '')
        {
            $this->params[self::P_REQ_DESCRIPTION] = !empty($value) ? $value : 'Order payment';
        }

        public function setCustomerId($value = '')
        {
            $this->params[self::P_REQ_CUSTOMER_ID] = !empty($value) ? strval($value) : 'unregistered';
        }

        public function setCustomerEmail($value = '')
        {
            $this->params[self::P_REQ_CUSTOMER_EMAIL] = !empty($value) ? strval($value) : 'unregistered';
        }

        public function setCustomerFirstName($value = '')
        {
            if (!empty($value)) {
                $this->params[self::P_REQ_CUSTOMER_FNAME] = $value;
            }
        }

        public function setCustomerLastName($value = '')
        {
            if (!empty($value)) {
                $this->params[self::P_REQ_CUSTOMER_LNAME] = $value;
            }
        }

        public function setCustomerPhone($value = '')
        {
            if (!empty($value)) {
                $this->params[self::P_REQ_CUSTOMER_PHONE] = $value;
            }
        }

        public function setProducts($value = [])
        {
            $this->params[self::P_REQ_PRODUCTS] = is_array($value) ? $value : [];
        }

        public function addProduct($value = [])
        {
            if (is_array($value) && !empty($value)) {
                $this->params[self::P_REQ_PRODUCTS][] = $value;
            }
        }

        /**
         * set custom params
         *
         * @param array $value
         */
        public function setParams($value = [])
        {
            $this->params = is_array($value) ? $value : [];
        }

        /**
         * set custom value
         *
         * @param string $value
         */
        public function setPayLoad($value = '')
        {
            $this->params[self::P_OPT_PAYLOAD] = $value;
        }

        /**
         * @return array
         */
        public function getReqParams()
        {
            return $this->params;
        }

        /**
         * @return mixed
         */
        public function createCreditPayment()
        {
            self::writeLog('createCreditPayment', '');
            $this->params[self::P_REQ_MODE]             = self::P_MODE_DIRECT;
            $this->params[self::P_REQ_METHOD]           = 'credit';
            $this->params[self::P_REQ_POS_ID]           = $this->posId;
            $this->params[self::P_REQ_ORDER_3DS_BYPASS] = 'never';

            $uri = self::U_METHOD_PAYMENT;
            $this->setHeader('Content-Type:application/json');

            return $this->request(self::R_METHOD_POST, $uri);
        }

        /**
         * @param $type_payment
         *
         * @return mixed
         */
        public function createPaymentDirect($type_payment)
        {
            self::writeLog('createPaymentDirect', '');
            $this->params[self::P_REQ_MODE]   = self::P_MODE_DIRECT;
            $this->params[self::P_REQ_POS_ID] = $this->posId;

            $this->setHeader('Accept: application/json');
            $this->setHeader('Content-Type: application/json');

            self::writeLog('type_payment', $type_payment);
            if (empty($type_payment)) {
                $this->params[self::P_REQ_METHOD] = self::P_METHOD_PURCHASE;
            } elseif ($type_payment == self::P_METHOD_LOOKUP) {
                $this->params[self::P_REQ_METHOD] = self::P_METHOD_LOOKUP;
            } else {
                $this->params[self::P_REQ_METHOD] = self::P_METHOD_AUTH;
            }
            self::writeLog('name type_payment', $this->params[self::P_REQ_METHOD]);
            return $this->request(self::R_METHOD_POST, self::U_METHOD_PAYMENT);
        }

        /**
         * @param $type_payment
         *
         * @return mixed
         */
        public function createPaymentHosted($type_payment)
        {
            $this->params[self::P_REQ_POS_ID] = $this->posId;
            $this->params[self::P_REQ_MODE]   = self::P_MODE_HOSTED;
            //new
            //$this->params[self::P_REQ_METHOD] = 'purchase';
            //new
            $this->params[self::P_REQ_ORDER_3DS_BYPASS] = 'supported';

            $this->setHeader('Accept: application/json');
            $this->setHeader('Content-Type: application/json');

            //new
            self::writeLog('type_payment', $type_payment);
            if (empty($type_payment)) {
                $this->params[self::P_REQ_METHOD] = self::P_METHOD_PURCHASE;
            } else {
                $this->params[self::P_REQ_METHOD] = self::P_METHOD_AUTH;
            }
            self::writeLog('name type_payment', $this->params[self::P_REQ_METHOD]);
            return $this->request(self::R_METHOD_POST, self::U_METHOD_PAYMENT);
            //new
        }

        //new
        public function createVoid($params = [])
        {
            self::writeLog('createVoid', '');
            $params[self::P_REQ_POS_ID] = $this->posId;

            $this->setHeader('Accept: application/json');
            $this->setHeader('Content-Type: application/json');

            self::writeLog('POS_ID', ['posId' => $params[self::P_REQ_POS_ID]]);
            self::writeLog('createVoid -> params', ['params' => $params]);

            return $this->request(self::R_METHOD_POST, self::U_METHOD_VOID, $params);
        }

        public function createCapture($params = [])
        {
            self::writeLog('createCapture', '');
            $params[self::P_REQ_POS_ID] = $this->posId;
            $this->setHeader('Accept: application/json');
            $this->setHeader('Content-Type: application/json');

            self::writeLog('POS_ID', ['posId' => $params[self::P_REQ_POS_ID]]);
            self::writeLog('createCapture -> params', ['params' => $params]);

            return $this->request(self::R_METHOD_POST, self::U_METHOD_CAPTURE, $params);
        }
        //new

        /**
         * @return mixed
         */
        public function checkPaymentStatus()
        {
            $uri = self::U_METHOD_POS . '/' . $this->posId . '/orders/' . $this->params[self::P_REQ_ORDER];

            return $this->request(self::R_METHOD_GET, $uri, []);
        }

        /**
         * @return mixed
         */
        public function checkStatus()
        {
            $uri = self::U_METHOD_POS . '/' . $this->posId . '/orders/0';

            return $this->request(self::R_METHOD_GET, $uri, []);
        }

        /**
         * @param $params
         *
         * @return mixed
         */
        private function request($method, $uri, $params = null)
        {
            //new
            //$url = $this->apiUrl . $uri;
            $url = $this->apiUrl . '/' . $uri;
            //new
            $params = is_null($params) ? $this->params : $params;
            $data   = json_encode($params);

            if (json_last_error()) {
                self::writeLog('json_last_error', json_last_error(), 'error');
                self::writeLog('json_last_error_msg', json_last_error_msg(), 'error');
            }

            $this->setHeader('X-API-Auth: CPAY ' . $this->apiKey . ':' . $this->apiSecret);
            $this->setHeader('X-API-KEY: ' . $this->endpointsKey);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            if ($method === self::R_METHOD_POST) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

            $server_response = curl_exec($ch);
            $http_code       = curl_getinfo($ch);
            $errno           = curl_errno($ch);
            curl_close($ch);

            // for check request лог
            self::writeLog('Request URL', $url);
            self::writeLog('Request params', ['params' => $params]);

//        self::writeLog('Request headers', array('headers' => $this->headers));
//        self::writeLog('Request httpcode', array("httpcode" => $http_code, "errno" => $errno));
            self::writeLog('response', $server_response);

            if (!$errno && empty($server_response)) {
                return $http_code;
            } else {
                return ((json_decode($server_response, true)) ? json_decode($server_response, true) : $server_response);
            }
        }

        /**
         * @param $params
         *
         * @return mixed
         */
        public function createRefund($params = [])
        {
            self::writeLog('createRefund', '');
            $params[self::P_REQ_POS_ID] = $this->posId;

            $this->setHeader('Accept: application/json');
            $this->setHeader('Content-Type: application/json');

            return $this->request(self::R_METHOD_POST, self::U_METHOD_REFUND, $params);
        }

        /**
         * @param $data
         * @param $requestSign
         *
         * @return bool
         */
        public function validateSignature($data, $requestSign)
        {
            $signStr = $this->apiSecret . $data . $this->apiSecret;
            $sign    = self::base64url_encode(sha1($signStr, true));

            if ($requestSign !== $sign) {
                return false;
            }

            return true;
        }

        /**
         * @param $params
         *
         * @return string
         */
        private function createSign($params)
        {
            $json      = self::base64url_encode(json_encode($params));
            $signature = $this->strToSign($this->apiSecret . $json . $this->apiSecret);
            return $signature;
        }

        /**
         * @param $str
         *
         * @return string
         */
        private function strToSign($str)
        {
            return self::base64url_encode(sha1($str, 1));
        }

        /**
         * @param $data
         *
         * @return string
         */
        public static function base64url_encode($data)
        {
            return strtr(base64_encode($data), '+/', '-_');
        }

        /**
         * @param $data
         *
         * @return bool|string
         */
        public static function base64url_decode($data)
        {
            return base64_decode(strtr($data, '-_', '+/'));
        }

        /**
         * @param $data
         *
         * @return mixed
         */
        public static function parseDataResponse($data)
        {
            return json_decode(self::base64url_decode($data), true);
        }

        /**
         * @param $header
         */
        private function setHeader($header)
        {
            $this->headers[] = $header;
        }

        /**
         * @param $key
         *
         * @return mixed
         */
        private function getHeader($key)
        {
            return $this->headers[$key];
        }

        /**
         * @param string $value
         * @param        $round
         *
         * @return float
         */
        static function amountToDouble($value = '', $round = null)
        {
            $val = floatval($value);
            return is_null($round) ? round($val, 2) : round($value, (int)$round);
        }

        /**
         * @param        $message
         * @param        $data
         * @param string $type
         */
        static function writeLog($message, $data, $type = 'info')
        {
            if (config('tranzzo.log_enabled')) {
                if (!isset($data)) {
                    $data = '';
                }
                $data = is_array($data) ? json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) : $data;
                if ($type == 'error') {
                    Log::error('TranzzoApi: ' . $message . ' | ' . $data);
                } else {
                    Log::info('TranzzoApi: ' . $message . ' | ' . $data);
                }

            }
        }


    }
