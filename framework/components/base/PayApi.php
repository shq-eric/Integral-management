<?php
namespace BaseComponents\base;

abstract class PayApi
{

    public $error;

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 生成签名
     * 
     * @param unknown $data            
     */
    abstract public function sign($data);

    /**
     * 验证签名
     * 
     * @param unknown $data            
     */
    abstract public function checkSign($data);

    /**
     * 调用充值
     * 
     * @param unknown $orderSn            
     * @param unknown $amount（单位：分）            
     * @param unknown $subject            
     * @param string $description            
     */
    abstract public function callRecharge($orderSn, $amount, $subject, $description = '');
}
?>