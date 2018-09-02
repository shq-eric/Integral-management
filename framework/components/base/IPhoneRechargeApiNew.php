<?php
namespace BaseComponents\base;

interface IPhoneRechargeApiNew {
    
    public static function getInstance(IJuheApiConfig $config);
    
    public function rechargeCheck($phone, $denomination);
    
    public function recharge($phone, $denomination, $orderSn);
    
    public function checkSign($params);
    
    public function getError();
    
    public function getRaw();
    
    public function getBalance();
    
    /**
     * 
     * @param array $params
     * @param string $raw
     * @return \BaseComponents\base\ApiResult
     */
    public function parseCallbackResult($params, $raw = null);
}