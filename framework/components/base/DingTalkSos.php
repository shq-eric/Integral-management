<?php
/**
 * Created by PhpStorm.
 * User: @Faith
 * Date: 2017-08-10
 * Time: 16:55
 */

namespace BaseComponents\base;

class DingTalkSos
{
    private static $api = "/ding/notice";

    private static $secret = "6713CAA687A8CCDB4E296DD25B1A0105";

    private static $domain = 'http://msg.mailejifen.com';

    public static function sendRobotNotify($platform, $groupId, $content)
    {
        $params = [
            'platform' => $platform,
            'groupId' => $groupId,
            'noticeType' => 'robot',
            'content' => $content,
            'time' => time()
        ];
        try {
            $params['sign'] = self::getSign($params, self::$secret);
            Http::run(self::$domain . self::$api, $params, 'get');
        } catch (\Exception $e) {
        }
    }

    public static function sendRobotNotifyByPhone($platform, $groupId, $content, $phone)
    {
        $params = [
            'platform' => $platform,
            'groupId' => $groupId,
            'noticeType' => 'robot',
            'atMobiles' => $phone,
            'content' => $content,
            'time' => time()
        ];
        try {
            $params['sign'] = self::getSign($params, self::$secret);
            Http::run(self::$domain . self::$api, $params, 'get');
        } catch (\Exception $e) {
        }
    }

    public static function sendCorpNotify($platform, $toUser, $content)
    {
        $params = [
            'platform' => $platform,
            'toUser' => $toUser,
            'noticeType' => 'corp',
            'content' => $content,
            'time' => time()
        ];
        try {
            $params['sign'] = self::getSign($params, self::$secret);
            Http::run(self::$domain . self::$api, $params, 'get');
        } catch (\Exception $e) {
        }
    }

    private static function getSign($params, $secret)
    {
        ksort($params);
        $s = '';
        foreach ($params as $k => $v) {
            $s .= $v;
        }
        $s .= $secret;

        return md5($s);
    }

}
