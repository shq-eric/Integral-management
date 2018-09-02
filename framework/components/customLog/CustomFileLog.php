<?php

namespace BaseComponents\customLog;

use Yii;
use yii\log\FileTarget;
use yii\log\Logger;
use yii\web\Request;

class CustomFileLog extends FileTarget {

    public function formatMessage($message)
    {
        list($text, $level, $category, $timestamp) = $message;	
		$datetime = date('Y/m/d H:i:s',$timestamp);
		$level = Logger::getLevelName($level);
        $request = Yii::$app->getRequest();
        $ip = $request instanceof Request ? $request->getUserIP() : '-';

		return "[{$datetime}] [{$level}] [{$category}] [{$text}] [{$ip}]\n";
	}

}

?>