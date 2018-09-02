<?php
namespace BaseComponents\base;

use BaseComponents\exceptions\LogException;

class MaileNoticeMessage
{

    private static $batchBuff;

    private static $batchMaxNum = 1000;
    // 每批最多发多少条
    public static function addHttpNoticeMessage($url, $method = 'get', $params = null, $headers = null)
    {
        if (!empty($params)) {
            foreach ($params as &$v) {
                $v = strval($v);
            }
        }
        
        self::$batchBuff['types'][] = 'http';
        self::$batchBuff['bodies'][] = json_encode(self::buildHttpNoticeBody($url, $method, $params, $headers));
        if (count(self::$batchBuff['types']) >= self::$batchMaxNum) {
            self::send();
        }
    }

    public static function send()
    {
        if (empty(self::$batchBuff['types'])) {
            return;
        }
        
        $params = [
            'type' => join('|', self::$batchBuff['types']),
            'body' => join('|', self::$batchBuff['bodies'])
        ];
        
        $url = \Yii::$app->params['noticeMessageApi'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 25);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        
        $raw = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($ch);
        curl_close($ch);
        
        if ($curlErrNo) {
            \Yii::error('通知消息提交失败（CURL:' . $curlErrNo . '）');
            throw new LogException(500, '通知消息提交失败（CURL:' . $curlErrNo . '）');
        } else {
            $response = json_decode($raw, true);
            if (! $response) {
                \Yii::error("通知消息提交失败[$raw]");
                throw new LogException(500, "通知消息提交失败[$raw]");
            }
            
            if ($response['code'] !== 0) {
                \Yii::error("通知消息提交失败[$raw]");
                throw new LogException(500, "通知消息提交失败[{$response['msg']}]");
            }
        }
        
        self::clearBuff();
    }

    private static function buildHttpNoticeBody($url, $method = 'get', $params = null, $headers = null)
    {
        $body = [
            'url' => $url,
            'method' => $method
        ];
        
        if (! empty($params)) {
            $body['params'] = $params;
        }
        
        if (! empty($headers)) {
            $body['headers'] = $headers;
        }
        
        return $body;
    }

    private static function clearBuff()
    {
        self::$batchBuff = [
            'types' => [],
            'bodies' => []
        ];
    }
}

?>