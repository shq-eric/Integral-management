<?php
namespace BaseComponents\base;

use BaseComponents\exceptions\AppException;

class SignureManager
{

    const PARAM_SIGN = 'sign';

    const PARAM_TIME_STAMP = 'timeStamp';

    private static function keyMaps()
    {
        return [
            [
                'from' => 'admin',
                'to' => 'erp',
                'key' => 'afdtierhtierthuieryqw'
            ],
            [
                'from' => 'erp',
                'to' => 'admin',
                'key' => 'gfhrityeuirhyigasgfu'
            ],
            [
                'from' => 'samsung',
                'to' => 'erp',
                'key' => 'bfsdjfbkweuikmkasfhk'
            ],
            [
                'from' => 'erp',
                'to' => 'samsung',
                'key' => 'gwrtk23jhc;saodsduqd'
            ]
        ];
    }

    public static function getPlatformKey($fromPlatform, $toPlatform)
    {
        $maps = self::keyMaps();
        foreach ($maps as $item) {
            if ($item['from'] == $fromPlatform && $item['to'] == $toPlatform) {
                return $item['key'];
            }
        }
        
        throw new AppException(105, "获取签名key失败：{$fromPlatform} -> {$toPlatform}");
    }

    /**
     * 对参数进行签名
     *
     * @param unknown $params            
     * @param unknown $toPlatform            
     * @return unknown
     */
    public static function sign(&$params, $toPlatform)
    {
        if (isset($params[self::PARAM_SIGN])) {
            unset($params[self::PARAM_SIGN]);
        }
        
        if (isset($params[self::PARAM_TIME_STAMP])) {
            unset($params[self::PARAM_TIME_STAMP]);
        }
        
        $key = self::getPlatformKey(self::platform(), $toPlatform);
        
        $params[self::PARAM_TIME_STAMP] = time();
        ksort($params);
        $signStr = join('', $params) . $key;
        $params[self::PARAM_SIGN] = md5($signStr);
        
        return $params;
    }

    /**
     * 对参数进行签名验证
     *
     * @param unknown $params            
     * @param unknown $fromPlatform            
     * @param number $expire            
     * @throws AppException
     */
    public static function requireSign($params, $fromPlatform, $expire = 600)
    {
        $sign = isset($params[self::PARAM_SIGN]) ? $params[self::PARAM_SIGN] : '';
        $timeStamp = isset($params[self::PARAM_TIME_STAMP]) ? $params[self::PARAM_TIME_STAMP] : '';
        unset($params[self::PARAM_SIGN]);
        
        $toPlatform = defined('PLATFORM') ? PLATFORM : \Yii::$app->params['platform'];
        
        $key = self::getPlatformKey($fromPlatform, self::platform());
        
        if (! $sign || ! $timeStamp) {
            throw new AppException(100, '签名参数错误');
        }
        
        $now = time();
        if (abs($now - $timeStamp) > $expire) {
            throw new AppException(101, '签名已过期');
        }
        
        ksort($params);
        $signStr = join('', $params) . $key;
        if (md5($signStr) != $sign) {
            throw new AppException(102, '签名错误');
        }
    }

    private static function platform()
    {
        return defined('PLATFORM') ? PLATFORM : \Yii::$app->params['platform'];
    }
}