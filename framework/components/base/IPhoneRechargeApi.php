<?php
namespace BaseComponents\base;

interface IPhoneRechargeApi {
    
    public static function getInstance();
    
    public function rechargeCheck($phone, $denomination);
    
    public function recharge($phone, $denomination, $orderSn);
    
    public function checkSign($params);
    
    public function getError();
    
    public function getRaw();
    
    /**
     * 
     * @param array $params
     * @param string $raw
     * @return \BaseComponents\base\ApiResult
     */
    public function parseCallbackResult($params, $raw = null);
}