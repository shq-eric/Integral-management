<?php
namespace BaseComponents\exceptions;

/**
 * Http异常（404,500等）（不记录日志）
 * @author Nekoing
 *
 */
class AppHttpException extends AppException
{
    public $statusCode;
    public function __construct($statusCode)
    {
        $this->statusCode = $statusCode;
        parent::__construct('', 0);
    }
}
?>