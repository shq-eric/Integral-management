<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/2/22
 * Time: 下午1:32
 */
class message
{
    private $_singleUrl = 'http://120.26.69.248/msg/HttpSendSM';
    private $_mulitUrl = 'http://120.26.69.248/msg/HttpBatchSendSM';
    //测试账号
    private $_account = '002008';
    private $_pswd = 'Sy002008';
    //实际账号
    private $_needStatus = 'true';//必须是字符串

    public function singleMessage($mobile,$msg)
    {
        if(!empty($mobile) && !empty($msg)) {
            $params = ['account' => $this->_account, 'pswd' => $this->_pswd, 'mobile'=>$mobile,'msg'=>$msg,'needstatus'=>$this->_needStatus];
            return $this->_singleUrl.'?'.http_build_query($params);
        }
        else {
            throw new \Exception("you should set params include `mobile` and `msg`");
        }
    }
}