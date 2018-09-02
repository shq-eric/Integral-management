<?php
namespace BaseComponents\base;

class ApiResult
{

    const RESULT_OK = 0;

    const RESULT_FAILED = 9;

    const RESULT_EXCEPTION = 99;

    public $result;

    public $errMsg;

    public $orderSn;

    public $apiOrderSn;

    public $data;

    public $raw;

    public function toParams()
    {
        return [
            'result' => $this->result,
            'errMsg' => $this->errMsg,
            'orderSn' => $this->orderSn,
            'apiOrderSn' => $this->apiOrderSn,
            'data' => $this->data,
            'raw' => $this->raw
        ];
    }

    public static function parseParams($params)
    {
        $result = new self();
        $result->result = intval($params['result']);
        $result->orderSn = $params['orderSn'];
        $result->apiOrderSn = isset($params['apiOrderSn']) ? $params['apiOrderSn'] : null;
        $result->data = isset($params['data']) ? htmlspecialchars_decode($params['data']) : null;
        $result->errMsg = isset($params['errMsg']) ? $params['errMsg'] : null;
        $result->raw = isset($params['raw']) ? htmlspecialchars_decode($params['raw']) : null;
        
        return $result;
    }
}