<?php
/**
 * Created by PhpStorm.
 * User: neo.xu
 * Date: 2015/9/7
 * Time: 16:33
 */
namespace app\components;

use BaseComponents\base\CacheName;
use BaseModels\Config;
use yii\helpers\Json;
use Yii;

class CoreHelper extends \BaseComponents\base\CoreHelper{

    /**
     * 获取 hash cookie中的值
     * @param string $hashKey
     * @param string $subKey
     * @return $hashVal
     */
    public static function getHashCookie($hashKey, $subKey) {
        $hashVal = self::getCookie ( $hashKey );
        $hashVal = Json::decode ( $hashVal );
        if (isset ( $hashVal [$subKey] )) {
            return $hashVal [$subKey];
        } else {
            return null;
        }
    }

    /**
     * 设置 hash cookie值，保持原来cookie其他key值
     * @param unknown $hashKey
     * @param unknown $subKey
     * @param unknown $value
     */
    public static function setHashCookie($hashKey, $subKey, $value) {
        $hashVal = self::getCookie ( $hashKey );
        $hashVal = Json::decode ( $hashVal );
        $hashVal [$subKey] = $value;
        $hashVal = Json::encode ( $hashVal );
        $oneYear = COOKIE_EXPIRE * 12;
        self::setCookie ( $hashKey, $hashVal, $oneYear );
    }

    /**
     * @param $key
     * @param bool $prefix
     * @return bool|null
     */
    public static function getCookie($key, $prefix = true) {
        if (empty ( $key )) {
            return false;
        }
        /* 二维 */
        if (preg_match ( "/\[.*?\]/", $key )) {
            $posL = strrpos ( $key, '[' );
            $posR = strrpos ( $key, ']' );
            $oneDim = substr ( $key, 0, $posL );
            $twoDim = substr ( $key, $posL + 1, $posR - $posL - 1 );

            $value = ! empty ( $_COOKIE [$oneDim] [$twoDim] ) ? $_COOKIE [$oneDim] [$twoDim] : null;
        }else {
            if ($prefix && stristr ( $key, COOKIE_PREFIX ) === FALSE) {
                $key = COOKIE_PREFIX . $key;
            }
            $value = empty ( $_COOKIE [$key] ) ? null : $_COOKIE [$key];
        }
        return $value;
    }

    /**
     * ription 获取配置
     */
    public static function getOption($key, $default = null) {
        static $option = null;
        $cacheKey = CacheName::CONFIG . ':' . $key;
        if (isset ( $option [$key] ) && $option [$key]) {
            return $option [$key];
        }
        $data = Yii::$app->redis->get ( $cacheKey );
        if ($data === false) {
            $res = Config::getWxConfig($key);
            if ($res === null || $res === false) {
                if ($default !== null) {
                    $data = $default;
                } else {
                    return '';
                }
            } else {
                $data = $res;
            }
            Yii::$app->redis->set ( $cacheKey, $data );
        }
        $option [$key] = $data;
        return $data;
    }

    /**
     * 初始化返回
     *
     * @return StdClass
     */
    public static function initResult()
    {
        $result = new \stdClass();
        $result->code = 0;
        $result->data = [];
        $result->extend = [];
        $result->msg = 'success';
        return $result;
    }

}