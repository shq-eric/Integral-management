<?php
namespace BaseComponents\base;

use BaseComponents\exceptions\AppException;

class JuheFeesApiNew implements IPhoneRechargeApiNew
{

    const API_CHECK = 'http://op.juhe.cn/ofpay/mobile/telcheck';

    const API_RECHARGE = 'http://op.juhe.cn/ofpay/mobile/onlineorder';
    
    const API_BALANCE = 'http://op.juhe.cn/ofpay/mobile/yue';

    protected static $instance;

    protected $error;

    protected $responseRaw;

    protected $banCodePattern = '/^(208517|208515|1\d+)$/';
    
    protected $config;

    public function __construct(IJuheApiConfig $config)
    {
        $this->config = $config;
    }
    
    /**
     *
     * @return \BaseComponents\base\IPhoneRechargeApi
     */
    static public function getInstance(IJuheApiConfig $config)
    {
        if (! self::$instance) {
            self::$instance = new static($config);
        }
        
        return self::$instance;
    }

    public function rechargeCheck($phone, $denomination)
    {
        $params = [
            'cardnum' => $denomination,
            'phoneno' => $phone,
            'key' => $this->config->key()
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
            'key' => $this->config->key()
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

    public function getBalance()
    {
        if(get_class($this) != "BaseComponents\\base\\JuheFeesApiNew") {
            throw new \Exception('请使用话费API查询余额');
        }
        
        $time = time();
        $params = [
            'timestamp' => $time,
            'key' => $this->config->key(),
            'sign' => md5($this->config->openid() . $this->config->key() . $time)
        ];
    
        try {
            $this->responseRaw = Http::run(static::API_BALANCE, $params, Http::GET, true);
            $result = json_decode($this->responseRaw, true);
        } catch (\Exception $e) {
            throw new AppException(416, 'API接口调用失败');
        }
    
        if ($result && $result['error_code'] === 0) {
            return $result['result']['money'];
        }
        else {
            $this->error = $result['reason'];
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
        
        $result->apiOrderSn = isset($params['sporder_id']) ? $params['sporder_id'] : '';
        
        if ($params['sta'] == 9) {
            $result->result = ApiResult::RESULT_FAILED;
            $result->errMsg = isset($params['err_msg']) ? $params['err_msg'] : '';
        } else {
            $result->result = ApiResult::RESULT_OK;
        }
        
        return $result;
    }

    public function sign($params)
    {
        return md5($this->config->openid() . $this->config->key() . $params['phoneno'] . $params['cardnum'] . $params['orderid']);
    }

    public function checkSign($data)
    {
        return $data['sign'] === md5($this->config->key() . $data['sporder_id'] . $data['orderid']);
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

