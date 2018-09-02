<?php
namespace BaseComponents\base;

use BaseComponents\exceptions\AppException;

class HuyiCouponApi
{

    const API = 'http://f.ihuyi.com/giftcard';

    const APP_ID = '89011395';

    const APP_KEY = '8acj19fNigTg94FS6Ds9';

    protected static $instance;

    protected $error;

    protected $responseRaw;


    static public function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    //获取卡券列表
    public function getCouponList()
    {
        $timestamp = date('YmdHis');
        $params = [
            'action' => 'getproducts',
            'username' => self::APP_ID,
            'timestamp' => $timestamp,
            'sign' => $this->getSign(sprintf("apikey=%s&timestamp=%s&username=%s",
                self::APP_KEY,
                $timestamp,
                self::APP_ID
            ))
        ];

        $result = Http::run(static::API, $params, Http::GET, true);

        return json_decode($result, true);
    }

    public function getBalance()
    {
        $timestamp = date('YmdHis');

        $params = [
            'action' => 'getbalance',
            'username' => self::APP_ID,
            'timestamp' => $timestamp,
            'sign' => $this->getSign(sprintf("apikey=%s&timestamp=%s&username=%s",
                self::APP_KEY,
                $timestamp,
                self::APP_ID
            ))
        ];

        try {
            $this->responseRaw = Http::run(static::API, $params, Http::GET, true);
            $result = json_decode($this->responseRaw, true);
        } catch (\Exception $e) {
            throw new AppException(416, 'API接口调用失败');
        }

        if ($result && $result['code'] === 1) {
            return $result['balance'];
        } else {
            $this->error = "获取余额失败（ Msg : {$result['message']} ）";
            return false;
        }
    }


    public function getCard($productid, $orderSn, $buyNum)
    {
        $timestamp = date('YmdHis');
        $params = [
            'action' => 'buy',
            'buynum' => $buyNum,
            'mobile' => '',
            'orderid' => $orderSn,
            'productid' => $productid,
            'timestamp' => $timestamp,
            'username' => self::APP_ID,
            'sign' => $this->getSign(sprintf("apikey=%s&buynum=%s&mobile=%s&orderid=%s&productid=%s&timestamp=%s&username=%s",
                self::APP_KEY,
                $buyNum,
                '',
                $orderSn,
                $productid,
                $timestamp,
                self::APP_ID
            ))
        ];
        try {
            $this->responseRaw = Http::run(static::API, $params, Http::GET, true);
            $result = json_decode($this->responseRaw, true);
        } catch (\Exception $e) {
            throw new AppException(416, 'API接口调用失败');
        }
        \Yii::warning("huyi_coupon_id --[$productid]--" . json_encode($result));

        if ($result && $result['code'] === 1 && count($result['cards']) > 0) {
            $cards = [];
            foreach ($result['cards'] as $key => $val) {
                $cards[$key]['no'] = $this->decrypt($val['no']);
                $cards[$key]['pwd'] = $this->decrypt($val['pwd']);
                $cards[$key]['expired'] = !empty($val['expired']) ? date('Y-m-d H:i:s', $val['expired']) : '';
            }
            return $cards;
        } else {
            $this->error = "获取卡券异常（errCode : {$result['code']} Msg : {$result['message']} ）";
            return false;
        }
    }

    //卡号，密码解密
    private function decrypt($data, $isBase64 = 1)
    {
        $iv = substr(self::APP_KEY, 0, 8);
        $key = str_pad(self::APP_KEY, 24, '0');
        if ($isBase64) {
            $data = base64_decode($data);
        }
        $decrypted = mcrypt_decrypt(
            MCRYPT_3DES,
            $key,
            $data,
            MCRYPT_MODE_CBC,
            $iv
        );

        $result = $this->unPaddingPKCS7($decrypted);
        return $result;
    }

    private function unPaddingPKCS7($string)
    {
        $end = substr($string, -1);
        $last = ord($end);
        $len = strlen($string) - $last;

        if (substr($string, $len) == str_repeat($end, $last)) {
            return substr($string, 0, $len);
        }
        return false;
    }

    public function parseCallbackResult($params)
    {
        return $this->validateCallback($params);
    }

    public function getSign($params)
    {
        return md5($params);
    }

    public function checkSign($data)
    {
        return $data['sign'] === $this->getSign(sprintf("apikey=%s&message=%s&mobile=%s&state=%s&taskid=%s",
            self::APP_KEY,
            $data['message'],
            $data['mobile'],
            $data['state'],
            $data['taskid']
        ));
    }

    public function getError()
    {
        return $this->error;
    }

    public function getRaw()
    {
        return $this->responseRaw;
    }

    protected function validateCallback($params)
    {
        return isset($params['taskid']) && isset($params['orderid']) && isset($params['state']) && isset($params['sign']) && $this->checkSign($params);
    }
}

