<?php
namespace BaseComponents\base;

use BaseComponents\exceptions\AppException;

class JuheTrafficApiNew extends JuheFeesApiNew
{

    const API_LIST = 'http://v.juhe.cn/flow/list';

    const API_CHECK = 'http://v.juhe.cn/flow/telcheck';

    const API_RECHARGE = 'http://v.juhe.cn/flow/recharge';

    protected $banCodePattern = '/^(210505|210506|1\d+)$/';

    private $trafficPkgId;

    public function rechargeCheck($phone, $denomination)
    {
        $params = [
            'phone' => $phone,
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
            $flows = $result['result'][0]['flows'];
            
            foreach ($flows as $item) {
                if (strtoupper($this->gb2m($item['p'])) === strtoupper($this->gb2m($denomination))) {
                    $this->trafficPkgId = $item['id'];
                    return true;
                }
            }
            $this->error = '该手机号不支持此套餐';
            return false;
        } else {
            $this->error = $result['reason'];
            return false;
        }
    }

    public function recharge($phone, $denomination, $orderSn)
    {
        if (! $this->trafficPkgId) {
            $this->rechargeCheck($phone, $denomination);
        }
        
        $params = [
            'phone' => $phone,
            'pid' => $this->trafficPkgId,
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

    public function sign($params)
    {
        return md5($this->config->openid() . $this->config->key() . $params['phone'] . $params['pid'] . $params['orderid']);
    }

    private function gb2m($v1)
    {
        if (preg_match('/(\d+)G/i', $v1, $match)) {
            $v1 = intval($match[1]) * 1024 . 'M';
        }
        
        return $v1;
    }
}

