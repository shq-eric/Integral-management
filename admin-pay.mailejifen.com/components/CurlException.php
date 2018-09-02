<?php
namespace app\components;

use BaseComponents\exceptions\LogException;
class CurlException extends LogException
{
    public $errorNo;
    
    
    public function __construct($errorNo, $message = '', $previous = null)
    {
        $this->errorNo = $errorNo;
        
        parent::__construct(10005, $message, [
            'errorNo' => $errorNo
        ], $previous);
    }
}

?>