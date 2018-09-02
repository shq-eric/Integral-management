<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/2/22
 * Time: 下午1:33
 */
namespace BaseComponents\base;

use Yii;
use BaseComponents\base\Http;

class Message
{
    public function __call($name,$arguments) {
        static $_message = null;
        if(!is_object($_message)) {
            include_once VDIR.'/framework/vendor/message/message.php';
            $_message = new \message();
        }
        if( method_exists($_message,$name) ) {
            $url =  call_user_func_array([$_message,$name],$arguments);
            return $this->_curlMessage($url);
        }
        else {
            throw new \Exception("can't find the {$name} function!");
        }
    }

    private function _curlMessage($url)
    {
        $response = Http::run($url,[],1,true);
        if(strpos("\n",$response)>0) {
            list($res,$msgid) = explode("\n",$response);
            list($resptime,$respstatus) = explode(",",$res);
            return [
                'status' => $respstatus,
                'msgid' => $msgid,
                'time' => $resptime
            ];
        }
        else {
            list($resptime,$respstatus) = explode(",",$response);
            return [
                'status' => $respstatus,
                'msgid' => $resptime
            ];
        }
    }

}