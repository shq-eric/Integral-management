<?php
/**
 * Created by PhpStorm.
 * User: Nekoing
 * Date: 2018/5/17
 * Time: 16:32
 */

namespace BaseComponents\base;


class ExpressTraceNode
{
    public $desc = '';
    public $time = '';

    /**
     * ExpressTraceNode constructor.
     * @param string $desc
     * @param string $time
     */
    public function __construct($desc, $time)
    {
        $this->desc = $desc;
        $this->time = $time;
    }


}