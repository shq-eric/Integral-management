<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/10/26
 * Time: 下午3:10
 */
namespace BaseComponents\extensions\oauth;

use yii\base\Exception;

abstract class Token
{

    private static $_limitTime = 300;

    /**
     * 获取签名头
     * @param $token
     * @param string $params
     * @param string $source
     * @return array
     * @throws \Exception
     */
    public static function getValidatorHeaderAsArray($token, $params = [], $source = "")
    {
        $time = time();

        if (empty($source)) {
            $source = empty($_SERVER['HTTP_HOST']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];
        }

        if (empty($source)) {
            throw new \Exception("Cannot identify the domain name, please manually");
        }

        $str = "";
        if (!empty($params)) {
            ksort($params);
            $str = join("", $params);
        }

        $sign = md5($str . $time . $source . $token);
        return [
            "time:$time",
            "source:$source",
            "sign:$sign"
        ];
    }

    /**
     * 获取签名头
     * @param $token
     * @param string $params
     * @param string $source
     * @return array
     * @throws \Exception
     */
    public static function getValidatorHeaderAsKeyArray($token, $params = [], $source = "")
    {
        $time = time();

        if (empty($source)) {
            $source = empty($_SERVER['HTTP_HOST']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];
        }

        if (empty($source)) {
            throw new \Exception("Cannot identify the domain name, please manually");
        }

        $str = "";
        if (!empty($params)) {
            ksort($params);
            $str = join("", $params);
        }

        $sign = md5($str . $time . $source . $token);
        return [
            "time" => $time,
            "source" => $source,
            "sign" => $sign
        ];
    }

    /**
     * 获取请求头
     * @return array
     * @throws \Exception
     */
    public static function getRequestHeaders(&$params = [])
    {
        $time = isset($_SERVER['HTTP_TIME']) ? $_SERVER['HTTP_TIME'] : (isset($params['time']) ? $params['time'] : "");
        if (empty($time)) {
            throw new \Exception("Can not find the param of time in the http request headers");
        } else {
            if (isset($params['time'])) unset($params['time']);
    }

        $source = isset($_SERVER['HTTP_SOURCE']) ? $_SERVER['HTTP_SOURCE'] : (isset($params['source']) ? $params['source'] : "");
        if (empty($source)) {
            throw new \Exception("Can not find the param of source in the http request headers");
        } else {
            if (isset($params['source'])) unset($params['source']);
        }

        $sign = isset($_SERVER['HTTP_SIGN']) ? $_SERVER['HTTP_SIGN'] : (isset($params['sign']) ? $params['sign'] : "");
        if (empty($sign)) {
            throw new \Exception("Can not find the param of sign in the http request headers");
        } else {
            if (isset($params['sign'])) unset($params['sign']);
        }

        return [
            "time" => $time,
            "source" => $source,
            "sign" => $sign
        ];
    }

    /**
     * 验证请求
     * @param $token
     * @param array $params
     * @return bool
     * @throws \Exception
     */
    public static function validator($token, $params = [])
    {
        $headers = self::getRequestHeaders($params);
        $source = $headers["source"];
        $sign = $headers["sign"];
        $time = $headers["time"];


        if ((time() - $time) > self::$_limitTime) {
            throw new \Exception("The request timeout");
        }

        $str = "";
        if (!empty($params)) {
            ksort($params);
            $str = join("", $params);
        }
        if ($sign == md5($str . $time . $source . $token)) {
            return true;
        } else {
            throw new \Exception("Signature error");
        }
    }
}