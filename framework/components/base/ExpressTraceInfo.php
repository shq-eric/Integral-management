<?php
/**
 * Created by PhpStorm.
 * User: Nekoing
 * Date: 2018/5/17
 * Time: 16:30
 */

namespace BaseComponents\base;

/***
 * Class ExpressTraceInfo
 * @package app\components
 * @property ExpressTraceNode[] $trace_list
 */
class ExpressTraceInfo
{
    public $express_no;
    public $express_name;
    public $state_label = '';
    public $success = false;

    public $trace_list = [];

    /**
     * ExpressTraceInfo constructor.
     * @param $expressNo
     * @param $expressName
     */
    public function __construct($expressNo, $expressName)
    {
        $this->express_no = $expressNo;
        $this->express_name = $expressName;
    }

    public function addTrace(ExpressTraceNode $node)
    {
        $this->trace_list[] = $node;
    }
}