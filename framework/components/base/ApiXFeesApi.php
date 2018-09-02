<?php
namespace BaseComponents\base;

use BaseComponents\exceptions\LogException;

class ApiXFeesApi implements IPhoneRechargeApi
{

    protected $rechargeApi;

    protected $checkApi;

    protected $key;

    protected $callback;

    protected $error;

    protected $code;

    protected $responseRaw;

    protected $responseData;

    private static $instance;

    /**
     *
     * @return \BaseComponents\base\IPhoneRechargeApi
     */
    static public function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new static();
        }
        
        return self::$instance;
    }

    public function __construct()
    {
        $this->rechargeApi = \Yii::$app->params['phone_fees']['rechargeApi'];
        $this->checkApi = \Yii::$app->params['phone_fees']['checkApi'];
        $this->key = \Yii::$app->params['phone_fees']['key'];
        $this->callback = \Yii::$app->params['phone_fees']['callback'];
    }

    public function recharge($phone, $denomination, $orderSn)
    {
        $params = [
            'phone' => $phone,
            'price' => $denomination,
            'orderid' => $orderSn,
            'sign' => md5($phone . $denomination . $orderSn),
            'callback_url' => $this->callback
        ];
        
        return $this->get($this->rechargeApi, $params, $this->key);
    }

    public function rechargeCheck($phone, $denomination)
    {
        $params = [
            'phone' => $phone,
            'price' => $denomination
        ];
        return $this->get($this->checkApi, $params, $this->key);
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
            \Yii::warning('[apix] request:' . $finalUrl . '; response:' . $response);
            $this->responseRaw = $response;
            
            $response = json_decode($response, true);
            if (! $response) {
                $this->error = '充值系统异常，请稍后再试！(code: 0)';
            }
            
            $this->responseData = $response['Data'];
            if ($response['Code'] !== 0) {
                $this->code = $response['Code'];
                switch ($this->code) {
                    case 3:
                        $this->error = '充值系统异常，请稍后再试！(code: 3)';
                }
                
                $this->error = $response['Msg'];
                return false;
            }
            
            return true;
        }
    }

    public function checkSign($params)
    {
        if (! isset($params['state']) || ! isset($params['orderid']) || ! isset($params['ordertime']) || ! isset($params['sign'])) {
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