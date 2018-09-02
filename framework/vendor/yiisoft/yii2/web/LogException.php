<?php
/**
 * Created by PhpStorm.
 * User: neo.xu
 * Date: 2015/8/27
 * Time: 17:11
 */

namespace yii\web;

use Yii;
use BaseComponents\customLog\CustomLogger;

class LogException extends \Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $messages[] = $message;
        $messages[] = $code;
        Yii::warning(CustomLogger::formatMessage("LogException", '', $messages), "LogException");
    }

}