<?php

/**
 * Created by PhpStorm.
 * User: yaojiang
 * Date: 2018/05/17
 * Time: 上午10:00
 */

namespace BaseComponents\base;

use BaseComponents\exceptions\AppException;

class AliyunExpress
{
    private static $instance;
    protected $raw;
    protected $code;

    const EXPRESS_QUERY_API = 'https://wdexpress.market.alicloudapi.com/gxali';
    const EXPRESS_LIST_API = 'https://wdexpress.market.alicloudapi.com/globalExpressLists';
    const APP_CODE = '47455e4c401a4c3cb98e0c610b1368fe';

    public static $stateMap = [
        -1 => '单号或快递公司代码错误',
        0 => '暂无轨迹',
        1 => '快递收件',
        2 => '在途中',
        3 => '已签收',
        4 => '问题件'
    ];

    static public function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function query($expressSn, $expressName)
    {
        if (empty($expressSn) || empty($expressName)) {
            throw new AppException(ErrorCode::ERR_NO_PARAMETERS);
        }

        $params = [
            'n' => $expressSn,
            't' => $expressName
        ];

        $expressInfo = $this->call(self::EXPRESS_QUERY_API, $params);

        if (isset($expressInfo['State'])) {
            $expressInfo['State'] = isset(self::$stateMap[$expressInfo['State']]) ? self::$stateMap[$expressInfo['State']] : $expressInfo['State'];
        }

        $shipper = $this->getExpressList($expressInfo['ShipperCode']);
        if (!empty($shipper['result'])) {
            $expressInfo['ShipperCode'] = isset($shipper['result'][$expressInfo['ShipperCode']]) ? $shipper['result'][$expressInfo['ShipperCode']] : $expressInfo['ShipperCode'];
        }

        $expressTraceInfo = new ExpressTraceInfo($expressInfo['LogisticCode'], $expressInfo['ShipperCode']);
        $expressTraceInfo->state_label = $expressInfo['State'];
        $expressTraceInfo->success = $expressInfo['Success'];

        foreach ($expressInfo['Traces'] as $item) {
            $expressTraceInfo->addTrace(new ExpressTraceNode($item['AcceptStation'], $item['AcceptTime']));
        }

        return $expressTraceInfo;
    }


    private function getExpressList($expressName)
    {
        $params = [
            'type' => $expressName
        ];

        return $this->call(self::EXPRESS_LIST_API, $params);
    }

    private function call($api, $params, $appCode = self::APP_CODE, $method = 'GET')
    {

        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appCode);

        $url = $api . "?" . http_build_query($params);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$" . $api, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $this->raw = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($curl);
        if (!$curlErrNo) {
            if ($statusCode >= 200 && $statusCode < 300) {
                $result = json_decode($this->raw, true);
                if (!$result) {
                    throw new AppException(23001, "接口返回结果：" . $result);
                }
                return $result;
            } else {
                throw new AppException(23002, '接口调用状态码异常：' . $statusCode);
            }
        } else {
            throw new AppException(23003, "接口调用异常（CURL:{$curlErrNo}）");
        }
    }

}