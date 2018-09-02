<?php
namespace app\logics;

use Yii;

class BaseLogic
{
    public $error = null;   //错误时的错误数据

    protected $model = null;

    public function __construct() {
        $this->init();
    }

    public function init() {}
    
    /**
     * 抽象逻辑加载方法
     * @param $logic
     * @param $func
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function logic($logic, $func, $params = array())
    {
        static $_logic = [];
        if(isset($_logic[$logic]) && is_object($_logic[$logic])) {
            $object = $_logic[$logic];
        }
        else {
            if(class_exists(__NAMESPACE__.'\\'.$logic)){
                $namespaceLogic = __NAMESPACE__.'\\'.$logic;
                $object = $_logic[$logic] = new $namespaceLogic;
            }
            else {
                throw new \Exception("Can't find the {$logic} Logic Model",-1);
            }
        }

        if(method_exists($object,$func)) {
            return $object->$func($params);
        }
        else {
            throw new \Exception("Can't find the func {$func} in {$logic} Logic Model",-1);
        }

    }

    /**
     * 填充错误信息
     * @param unknown $code
     * @param string $message
     * @param string $data
     */
    protected function fillError($code, $message = '', $data = '') 
    {
        $this->error = [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }
}

?>