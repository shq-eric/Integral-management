<?php
namespace BaseComponents\base;

use BaseComponents\exceptions\AppException;

class HuyiTrafficApi
{

    const API = 'http://f.ihuyi.com/v2';

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

    //获取流量包档位
    public function getPackages()
    {
        $timestamp = date('YmdHis');
        $params = [
            'action' => 'getpackages',
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

    public function rechargeCheck($mobile, $denomination)
    {
        if ($this->getBalance() <= 10) {
            $this->error = '系统超时，请稍后重试';
            return false;
        }
        if ($this->getBalance() <= 1000) {
            $content = "[三星平台] \n 友情提示: 互亿第三方平台余额不足 \n 可用余额: " . $this->getBalance();
            $groupId = "wjjaubqk";
            DingTalkSos::sendRobotNotify('samsung', $groupId, $content);
        }
        return true;
    }

    public function recharge($mobile, $denomination, $orderSn)
    {
        $denomination = rtrim($denomination, "M");

        $timestamp = date('YmdHis');
        $params = [
            'action' => 'recharge',
            'mobile' => $mobile,
            'orderid' => $orderSn,
            'package' => $denomination,
            'timestamp' => $timestamp,
            'username' => self::APP_ID,
            'sign' => $this->getSign(sprintf("apikey=%s&mobile=%s&orderid=%s&package=%s&timestamp=%s&username=%s",
                self::APP_KEY,
                $mobile,
                $orderSn,
                $denomination,
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
            return true;
        } else {
            $this->error = "流量充值系统异常（ Msg : {$result['message']} ）";
            return false;
        }
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
        return $data['sign'] === $this->getSign(sprintf("apikey=%s&message=%s&mobile=%s&status=%s&taskid=%s",
            self::APP_KEY,
            $data['message'],
            $data['mobile'],
            $data['status'],
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
        return isset($params['taskid']) && isset($params['orderid']) && isset($params['status']) && isset($params['sign']) && $this->checkSign($params);
    }
}

