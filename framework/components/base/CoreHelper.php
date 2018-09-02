<?php
/**
 * Created by PhpStorm.
 * User: neo.xu
 * Date: 2015/9/7
 * Time: 16:33
 */
namespace BaseComponents\base;

use Yii;
use yii\helpers\Json;

class CoreHelper// extends \BaseComponents\base\CoreHelper
{
    /**
     * ription 获取配置
     */
    public static function getOption($key, $default = null) {
        static $option = null;
        $cacheKey = Yii::$app->params['cachePrefix']. ':' . $key;
        if (isset ( $option [$key] ) && $option [$key]) {
            return $option [$key];
        }
        $data = Yii::$app->redis->get ( $cacheKey );
        if ($data === false) {
            if ($default !== null) {
                $data = $default;
            } else {
                return '';
            }
            Yii::$app->redis->set ( $cacheKey, $data );
        }
        $option [$key] = $data;
        return $data;
    }


    public static function getCookie($key, $prefix = true)
    {
        if (empty ( $key )) {
            return false;
        }

         $value = false;

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

    public static function setCookie($key = '', $value = '', $expire = 0, $prefix = true) {
        if (empty ( $key ))
            return false;
        $now = CURRENT_TIMESTAMP;
        if ($expire == 0) {
            $time = $now + COOKIE_EXPIRE;
        } else if ($expire > 0) {
            $time = $expire;
        } else {
            $time = 0;
        }

        if ($prefix && ! preg_match ( "/\[.*?\]/", $key ) && stristr ( $key, COOKIE_PREFIX ) === FALSE) {
            $key = COOKIE_PREFIX . $key;
        }

        if ($key && $value) {
            return setcookie ( $key, $value, $time, COOKIE_PATH, COOKIE_DOMAIN );
        } else if ($key) {
            return setcookie ( $key, '', $now - 86400, COOKIE_PATH, COOKIE_DOMAIN );
        } else {
            return false;
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    public static function realIp() {
        if (! empty ( $_SERVER ['HTTP_CDN_SRC_IP'] )) {
            return $_SERVER ['HTTP_CDN_SRC_IP'];
        }

        if (isset ( $HTTP_SERVER_VARS )) {
            if (isset ( $HTTP_SERVER_VARS ["HTTP_X_FORWARDED_FOR"] )) {
                $realip = $HTTP_SERVER_VARS ["HTTP_X_FORWARDED_FOR"];
            } elseif (isset ( $HTTP_SERVER_VARS ["HTTP_CLIENT_IP"] )) {
                $realip = $HTTP_SERVER_VARS ["HTTP_CLIENT_IP"];
            } else {
                $realip = $HTTP_SERVER_VARS ["REMOTE_ADDR"];
            }
        } else {
            if (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
                $realip = getenv ( 'HTTP_X_FORWARDED_FOR' );
            } elseif (getenv ( 'HTTP_CLIENT_IP' )) {
                $realip = getenv ( 'HTTP_CLIENT_IP' );
            } else {
                $realip = getenv ( 'REMOTE_ADDR' );
            }
        }
        $realip = explode ( ',', $realip );
        return $realip [0];
    }

    public static function newRealIp()
    {
        if (!empty($_SERVER['HTTP_CDN_SRC_IP']) && filter_var($_SERVER['HTTP_CDN_SRC_IP'], FILTER_VALIDATE_IP) !== false) {
            return $_SERVER['HTTP_CDN_SRC_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $realip = explode(',', $realip)[0];
            if (isset($realip) && filter_var($realip, FILTER_VALIDATE_IP) !== false) {
                return $realip;
            }
        }

        return $_SERVER['REMOTE_ADDR'];
    }
}