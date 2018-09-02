<?php
namespace BaseComponents\base;

use BaseComponents\exceptions\AppException;

class JuheFeesApi implements IPhoneRechargeApi
{

    const API_CHECK = 'http://op.juhe.cn/ofpay/mobile/telcheck';

    const API_RECHARGE = 'http://op.juhe.cn/ofpay/mobile/onlineorder';

    const OPEN_ID = 'JH937712704c572f51cc704395889ab499';

    const KEY = '8fde5dd055d66b725128ae1fc3e0db60';

    protected static $instance;

    protected $error;

    protected $responseRaw;

    protected $banCodePattern = '/^(208517|208515|1\d+)$/';

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

    public function rechargeCheck($phone, $denomination)
    {
        $params = [
            'cardnum' => $denomination,
            'phoneno' => $phone,
            'key' => static::KEY
        ];
        
        $result = null;
        try {
            $this->responseRaw = Http::run(static::API_CHECK, $params, Http::GET, true);
            $result = json_decode($this->responseRaw, true);
        } catch (\Exception $e) {
            throw new AppException(416, 'API接口调用失败');
        }
        
        if ($result && $result['error_code'] === 0) {
            return true;
        } else {
            $this->error = $result['reason'];
            return false;
        }
    }

    public function recharge($phone, $denomination, $orderSn)
    {
        $params = [
            'phoneno' => $phone,
            'cardnum' => $denomination,
            'orderid' => $orderSn,
            'key' => static::KEY
        ];
        
        $params['sign'] = $this->sign($params);
        
        try {
            $this->responseRaw = Http::run(static::API_RECHARGE, $params, Http::GET, true);
            $result = json_decode($this->responseRaw, true);
        } catch (\Exception $e) {
            throw new AppException(416, 'API接口调用失败');
        }
        
        if ($result && $result['error_code'] === 0) {
            return true;
        } else {
            if (preg_match($this->banCodePattern, $result['error_code'])) {
                $this->error = "话费充值系统异常（code:{$result['error_code']}）";
            } else {
                $this->error = $result['reason'];
            }
            
            return false;
        }
    }

    public function parseCallbackResult($params, $raw = null)
    {
        $result = new ApiResult();
        if (! $raw) {
            $raw = json_encode($params);
        }
        $result->raw = $raw;
        
        $result->orderSn = isset($params['orderid']) ? $params['orderid'] : '';
        
        if (! $this->validateCallback($params)) {
            $result->result = ApiResult::RESULT_EXCEPTION;
            return $result;
        }
        
        $result->apiOrderSn = $params['sporder_id'];
        
        if ($params['sta'] == 9) {
            $result->result = ApiResult::RESULT_FAILED;
            $result->errMsg = $params['err_msg'];
        } else {
            $result->result = ApiResult::RESULT_OK;
        }
        
        return $result;
    }

    public function sign($params)
    {
        return md5(static::OPEN_ID . static::KEY . $params['phoneno'] . $params['cardnum'] . $params['orderid']);
    }

    public function checkSign($data)
    {
        return $data['sign'] === md5(static::KEY . $data['sporder_id'] . $data['orderid']);
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
        return isset($params['sporder_id']) && isset($params['orderid']) && isset($params['sta']) && isset($params['sign']) && $this->checkSign($params);
    }
}

