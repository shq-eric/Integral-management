<?php
namespace BaseComponents\base;

use BaseComponents\exceptions\LogException;

class ApiXCouponApi
{

    protected $rechargeApi;

    protected $listApi;

    protected $key;

    protected $error;

    protected $code;

    protected $responseRaw;

    protected $responseData;

    private static $instance;


    static public function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->listApi = \Yii::$app->params['apix_coupon']['listApi'];
        $this->rechargeApi = \Yii::$app->params['apix_coupon']['rechargeApi'];
        $this->checkStockApi = \Yii::$app->params['apix_coupon']['checkStockApi'];
        $this->key = \Yii::$app->params['apix_coupon']['key'];
    }

    //获取卡券列表
    public function getCouponList()
    {
        return $this->get($this->listApi, [], $this->key);
    }

    //检查卡券库存
    public function checkStock($cardId)
    {
        $params = [
            'cardid' => $cardId
        ];
        return $this->get($this->checkStockApi, $params, $this->key);

    }

    //获取卡券
    public function recharge($cardId, $orderSn)
    {
        $params = [
            'cardId' => $cardId,
            'orderId' => $orderSn,
            'md5Str' => strtoupper(md5($this->key . $orderSn . $cardId . \Yii::$app->params['apix_coupon']['KEY_STR']))
        ];
        $response = $this->get($this->rechargeApi, $params, $this->key);

        if ($response['code'] == 0 && !empty($response['data'])) {

            $data = [
                'code' => 0,
                'cardno' => $response['data']['cardno'],
                'cardpsw' => $response['data']['cardpsw'],
                'expiretime' => $response['data']['expiretime']
            ];

        } else {
            $data = [
                'code' => $response['code'],
                'msg' => $response['msg']
            ];

        }

        return $data;
    }


    protected function get($url, $params, $key = null)
    {
        $op = strpos('?', $url) === false ? '?' : '&';
        $finalUrl = $url . $op . http_build_query($params);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $finalUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "apix-key: $key",
                "content-type: application/json"
            ]
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new LogException(500, $err);
        } else {
            \Yii::warning('=====[apix]===== request:' . $finalUrl . '; response:' . $response);
            $this->responseRaw = $response;

            $response = json_decode($response, true);
            if (!$response) {
                $this->error = 'ApiX 系统异常，请稍后再试！(code: 0)';
            }

            return $response;
        }
    }

    public function checkSign($params)
    {
        if (!isset($params['state']) || !isset($params['orderid']) || !isset($params['ordertime']) || !isset($params['sign'])) {
            return false;
        }

        $sign = md5($this->key . $params['orderid'] . $params['ordertime']);
        return $params['sign'] === $sign;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getRaw()
    {
        return $this->responseRaw;
    }
}