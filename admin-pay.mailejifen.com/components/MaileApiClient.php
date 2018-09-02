<?php
namespace app\components;

use BaseComponents\exceptions\AppException;
use BaseComponents\exceptions\ApiCallException;

class MaileApiClient
{
    const TIMEOUT = 20;

    protected $raw;

    protected $code;

    private static $instance;

    static public function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function __construct()
    {}

    public function getRaw()
    {
        return $this->raw;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function call($api, $params = [], $method = 'get', $isRaw = false)
    {
        $url = $api;
        $method = strtolower($method);
        if ($method == 'get') {
            $url .= strpos($url, '?') > 0 ? '&' : '?' . http_build_query($params);
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        
        $this->raw = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($ch);
        curl_close($ch);
        
        $log = "[MaileApi Call] Request:$url;";
        $log .= $method == 'post' ? "Post:" . json_encode($params) . ";" : '';
        $log .= "Reponse:" . substr($this->raw, 0, 2048);
        
        if (! $curlErrNo) {
            if ($statusCode >= 200 && $statusCode < 300) {
                if (! $isRaw) {
                    $result = json_decode($this->raw, true);
                    if (! $result || ! isset($result['code'])) {
                        \Yii::error($log);
                        throw new ApiCallException(ErrorCode::ERR_API_RESULT_EXCEPTION, '', '', substr($this->raw, 0, 1024));
                    }
                    if ($result['code'] == 0) {
                        \Yii::info($log);
                        return $result['data'];
                    } else {
                        \Yii::warning($log);
                        throw new AppException($result['code'], $result['msg'], $result['data'], substr($this->raw, 0, 1024));
                    }
                } else {
                    \Yii::info($log);
                    return $this->raw;
                }
            } else {
                \Yii::error($log);
                throw new ApiCallException(ErrorCode::ERR_API_STATUS_EXCEPTION, '接口调用状态码异常：' . $statusCode, '', substr($this->raw, 0, 1024));
            }
        } else {
            \Yii::error($log);
            throw new ApiCallException(ErrorCode::ERR_API_REQUEST_EXCEPTION, "接口调用异常（CURL:{$curlErrNo}）", '', $this->raw);
        }
    }
}

?>