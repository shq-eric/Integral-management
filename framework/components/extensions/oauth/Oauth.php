<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/10/25
 * Time: 下午5:21
 */
namespace BaseComponents\extensions\oauth;

class Oauth {

    private static $_domain = "http://oauth.mailejifen.com";

    /**
     * 来源域查询token
     * @param key
     * @param secret
     * @param target
     * @return
     */
    public static function getSourceRequestUrl($key, $secret, $target) {
        $url = self::$_domain;
        
        $params = [
            "key" => $key,
            "time" => time(),
            "target" => $target
        ];

        ksort($params);

        $str = join("", $params);
        $str .= $secret;

        $params['sign'] = md5($str);
        return $url. "/auth/access?" . http_build_query($params);
    }

    /**
     * 目标域查询token
     * @param key
     * @param secret
     * @param Source
     * @return
     */
    public static function getTargetRequsetUrl($key, $secret, $source) {
        $url = self::$_domain;
        $params = [
            "key" => $key,
            "time" => time(),
            "target" => $source
        ];


        ksort($params);

        $str = join("", $params);
        $str .= $secret;

        $params['sign'] = md5($str);
        return $url. "/auth/get?" . http_build_query($params);
    }

}