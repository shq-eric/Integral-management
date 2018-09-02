<?php
namespace app\components;

use app\models\ApplicationModel;
use BaseComponents\exceptions\LogException;

class HttpClient
{

    static public function get($url, $params, $decode = true)
    {
        $url .= '?' . http_build_query($params);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        curl_close($ch);
        if (! $curl_errno) {
            \Yii::warning("[Consume Call] Request:$url; Reponse:$result");
            if ($decode) {
                $result = json_decode($result, true);
                if (! $result) {
                    throw new CurlException(99, '接口返回参数错误');
                }
            }
            return $result;
        } else {
            throw new CurlException($curl_errno);
        }
    }

    /**
     * 向App发起请求
     *
     * @param ApplicationModel $app            
     * @param array|string $params            
     * @param string $url            
     */
    static public function callAppApi(ApplicationModel $app, $params, $url, $decode = true, $isAsync = false)
    {
        $params['appKey'] = $app->setting->app_key;
        $params['timeStamp'] = CURRENT_TIMESTAMP;
        
        $params['sign'] = self::getSign($params, $app->setting->app_secret);
        
        return $isAsync ? self::asyncGet($url, $params) : self::get($url, $params, $decode);
    }

    static public function getSign($params, $secret)
    {
        ksort($params);
        $s = '';
        foreach ($params as $k => $v) {
            $s .= $v;
        }
        $s .= $secret;
        return md5($s);
    }

    static public function asyncGet($url, $params)
    {
        $url .= '?' . http_build_query($params);
        return \Yii::$app->redis->LPush('orderResult', $url);
    }
    
    static public function checkSign($params, $secret) 
    {
        if(!isset($params['sign'])) {
            throw new LogException(20006);
        }
        
        if(!intval($params['timeStamp']) || abs(intval($params['timeStamp']) - time()) > \Yii::$app->params['signLife']) {
            throw new LogException(20001);
        }
        
        $sign = $params['sign'];
        unset($params['sign']);
        ksort($params);
        if(md5(join('', $params).$secret) !== $sign) {
            throw new LogException(20006);
        }
    }
}

?>