<?php 
namespace BaseComponents\base;

class DingDingMessage {
    const REDIS_KEY = 'noticeMsg';
    
    const TYPE_STOCK = 'stock';
    const TYPE_REAL_ORDER = 'realOrder';
    const TYPE_RECHARGE_FAIL = 'rechargeFail';
    const TYPE_NEW_REGISTER = 'merchantReg';
    
    public static function send($type, $message)
    {
        try {
            return \Yii::$app->redis->lpush(self::REDIS_KEY, "$type|$message");
        }
        catch (\Exception $e){}
    }
}
?>