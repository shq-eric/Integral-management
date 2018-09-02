<?php
namespace BaseComponents\exceptions;

/**
 * 普通异常（不记录到日志）
 *
 * @author Nekoing
 *        
 */
class AppException extends \Exception
{
    const CODE = 999;

    protected $raw;

    protected $data;

    public function __construct($code, $message = '', $data = '', $raw = '', $previous = null)
    {
        if($code == self::CODE){
           $message = '系统异常';
        }
        $this->raw = $raw;
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getRaw()
    {
        return $this->raw;
    }
    
    public function setMessage($msg)
    {
        $this->message = $msg;
    }
}
?>