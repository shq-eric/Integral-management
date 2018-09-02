<?php
namespace BaseComponents\exceptions;

/**
 * 普通异常（记录到日志）
 *
 * @author Nekoing
 *        
 */
class LogException extends \Exception
{

    protected $raw;

    protected $data;

    public function __construct($code, $message = '', $data = '', $raw = '', $previous = null)
    {
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
}

?>