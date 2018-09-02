<?php
namespace BaseComponents\base;

class ApiXTrafficApi extends ApiXFeesApi
{

    private $trafficPkgId;

    public function __construct()
    {
        $this->rechargeApi = \Yii::$app->params['phone_traffic']['rechargeApi'];
        $this->checkApi = \Yii::$app->params['phone_traffic']['checkApi'];
        $this->key = \Yii::$app->params['phone_traffic']['key'];
        $this->callback = \Yii::$app->params['phone_traffic']['callback'];
    }

    public function recharge($phone, $denomination, $orderSn)
    {
        if (! $this->trafficPkgId) {
            $this->rechargeCheck($phone, $denomination);
        }
        
        $params = [
            'phone' => $phone,
            'pkgid' => $this->trafficPkgId,
            'orderid' => $orderSn,
            'sign' => md5($phone . $this->trafficPkgId . $orderSn),
            'callback_url' => $this->callback
        ];
        
        return $this->get($this->rechargeApi, $params, $this->key);
    }

    public function rechargeCheck($phone, $denomination)
    {
        $params = [
            'phone' => $phone
        ];
        
        if ($this->get($this->checkApi, $params, $this->key)) {
            $data = $this->responseData;
            foreach ($data['UserDataPackages'] as $package) {
                if (strcasecmp($package['DataValue'], $denomination) == 0) {
                    if ($package['DataValue'] == '无限次' || intval($package['DataValue']) > 0) {
                        $this->trafficPkgId = $package['PkgId'];
                        return true;
                    } else {
                        $this->error = '充值次数达到上限';
                        return false;
                    }
                }
            }
            $this->error = '该手机号不支持此套餐';
            return false;
        }
        return false;
    }
}