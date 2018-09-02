<?php
/**
 * Created by PhpStorm.
 * User: neo.xu
 * Date: 2015/8/14
 * Time: 17:49
 */
namespace app\controllers;

use Yii;
use yii\base\Controller;
use app\components\ErrorCode;
use app\filters\AccessFilter;
use app\components\LoginHelper;
use BaseComponents\exceptions\AppHttpException;
use BaseComponents\exceptions\AppException;
use BaseComponents\exceptions\LogException;

/**
 *
 * @author Nekoing
 */
class BaseController extends Controller
{
    // 抽象逻辑方法
    protected $logic;
    // 默认分页注册
    protected $pageSize = 20;
    //页面标题
    public $title = '';

    // 分页组件
    protected $pageHelper;
    
    public function init()
    {
        parent::init();
        set_exception_handler([$this, 'errorHandler']);
        \Yii::$app->session->open();

        LoginHelper::$admin_id = \Yii::$app->session->get('admin_id');
    }

    // public function __destruct()
    // {
    //     if (is_object(Yii::$app->mongodb)) {
    //         Yii::$app->mongodb->close();
    //     }
    // } 

    public function request($param = '', $value = null)
    {
        static $_request = null;
        if (is_null($_request)) {
            $_request = $this->_requestParam(array_merge($_GET, $_POST));
        }
        if (empty($param)) {
            return $_request;
        }

        if (isset($_request[$param])) {
            return $_request[$param];
        } else {
            return $value;
        }
    }

    /**
     * 递归处理参数
     * @param $params
     * @return string
     */
    private function _requestParam($params)
    {
        if (is_array($params)) {
            $tmp = [];
            foreach ($params as $key => $param) {
                $tmp[$key] = $this->_requestParam($param);
            }
            return $tmp;
        } else {
            return htmlspecialchars(trim($params), ENT_QUOTES);
        }
    }


    /**
     * smarty渲染模版
     *
     * @param
     *            $template
     * @param
     *            $data
     */
    public function display($template, $data = [])
    {
        if (strpos($template, '.') === false) {
            $template .= '.php';
        }

        $hasAt = 0;
        if ($template{0} == '@') {
            $template = substr($template, 1);
            $hasAt = 1;
        }

        if (strpos($template, '/') === false) {
            $template = $this->id . '/' . $template;
        }

        if ($this->module->id != 'basic' && !$hasAt) {
            $template = $this->module->id . '/' . $template;
        }

        $data['admin'] = LoginHelper::getAdmin();
        $data['title'] = $this->title;
        //$data['oostotal'] = $this->getOosTotal();
        //$data['delivertotal'] = $this->getDeliverTotal();
        foreach ($data as $key => $value) {
            Yii::$app->smarty->assign($key, $value);
        }

        Yii::$app->smarty->assign("YII_DEBUG", YII_DEBUG);
        Yii::$app->smarty->display($template);
    }

    /**
     * 是否已登录
     *
     * @return boolean
     */
    public function isLogin()
    {
        return !!\Yii::$app->session->get('admin_id');
    }

    /**
     * 是否Debug环境
     *
     * @return boolean
     */
    public function isDebug()
    {
        return defined('YII_DEBUG') && YII_DEBUG;
    }

    /**
     * 渲染json数据
     *
     * @param unknown $data
     * @param string $exit
     */
    protected function json($data, $exit = true)
    {
        $json = is_object($data) || is_array($data) ? json_encode($data) : strval($data);
        if (isset($_GET["jsonp"])) {
            header('Content-type: application/x-javascript');
            $json = sprintf("%s(%s)", $_GET["jsonp"], $json);
        } else {
            header('Content-type: application/json');
        }

        echo $json;
        $exit && exit();
    }

    /**
     * Ajax返回数据
     *
     * @param unknown $code
     * @param string $data
     * @param string $msg
     * @param string $exit
     */
    protected function ajaxReturn($code, $data = '', $message = '', $exit = true)
    {
        $json = json_encode([
            'code' => intval($code),
            'msg' => $message,
            'data' => $data
        ]);

        if (isset($_GET["jsonp"])) {
            header('Content-type: application/x-javascript');
            $json = sprintf("%s(%s)", $_GET["jsonp"], $json);
        } else {
            header('Content-type: application/json');
        }

        echo $json;
        $exit && exit();
    }

    /**
     * Ajax返回成功信息
     *
     * @param string $data
     */
    protected function ajaxSuccess($data = '')
    {
        return $this->ajaxReturn(0, $data);
    }

    /**
     * Ajax返回错误信息
     *
     * @param unknown $code
     * @param string $message
     * @param string $data
     */
    protected function ajaxFail($code, $message = '', $data = '')
    {
        if (is_array($code)) {
            $data = $code['data'];
            $message = $code['msg'];
            $code = $code['code'];
        }
        if (empty($message)) {
            $message = ErrorCode::getErrorMsg($code);
        }
        return $this->ajaxReturn($code, $data, $message);
    }

    protected function success($message, $url = null)
    {
        $this->display('@public/success', [
            'msg' => $message,
            'url' => $url,
        ]);
        Yii::$app->end();
    }

    protected function warning($message, $url = null)
    {
        $this->display('@public/warning', [
            'msg' => $message,
            'url' => $url,
        ]);
        Yii::$app->end();
    }

    protected function info($message, $url = null)
    {
        $this->display('@public/info', [
            'msg' => $message,
            'url' => $url,
        ]);
        Yii::$app->end();
    }

    protected function error($message, $url = null)
    {
        if (is_numeric($message)) {
            header("HTTP/1.1 $message");
            $this->display('@public/' . $message);
            Yii::$app->end();
        } else {
            $this->display('@public/error', [
                'msg' => $message,
                'url' => $url,
            ]);
            Yii::$app->end();
        }
    }

    /**
     * 异常捕获
     * @param \Exception $exception
     */
    public function errorHandler($exception)
    {
        if (!($exception instanceof LogException) && !($exception instanceof AppException)) {
            throw $exception;
        }

        if ($exception instanceof AppHttpException) {
            $this->error($exception->statusCode);
            exit();
        }

        //记录日志
        if ($exception instanceof LogException) {
            $message = $this->formatException($exception);
            \Yii::error($message);
        }

        $data = method_exists($exception, 'getData') ? $exception->getData() : '';
        $code = $exception->getCode();

        if (\Yii::$app->request->isAjax) {
            $this->ajaxFail($code, $exception->getMessage(), $data);
        } else {
            if ($exception->getMessage()) {
                $errorMessage = $exception->getMessage();
            } else {
                $errorMessage = ErrorCode::getErrorMsg($exception->getCode() ? $exception->getCode() : 500);
            }
            $this->error($errorMessage);
        }
    }

    /**
     * 格式化异常
     * @param \Exception $exception
     */
    protected function formatException($exception)
    {
        $action = $this->module->id == 'basic' ? '/' : '/' . $this->module->id . '/' . $this->id . '/' . $this->action->id;
        $struct = [
            'action' => $action,
            'code' => $exception->getCode(),
            'exception' => get_class($exception),
            'method' => $_SERVER['REQUEST_METHOD'],
            'request' => $_SERVER['REQUEST_URI'],
            'file' => $exception->getFile() . '(line ' . $exception->getLine() . ')',
        ];

        $trace = [];
        $fullTrace = $exception->getTrace();
        for ($i = 0; $i < count($fullTrace); $i++) {
            $trace[$i] = $fullTrace[$i];
            unset($trace[$i]['args']);
            unset($trace[$i]['type']);
        }
        $struct['trace'] = $trace;

        if (!empty($_POST)) {
            $struct['post'] = $_POST;
        }

        if (@$m = $exception->getMessage()) {
            $struct['msg'] = $m;
        } else if ($exception->getCode() && ErrorCode::getErrorMsg($exception->getCode())) {
            $struct['msg'] = ErrorCode::getErrorMsg($exception->getCode());
        }

        if (method_exists($exception, 'getData') && $d = $exception->getData()) {
            $struct['data'] = $d;
        }

        if (LoginHelper::$admin_id) {
            $struct['$admin_id'] = LoginHelper::$admin_id;
        }

        return json_encode($struct);
    }

    //跳转
    protected function redirect($url, $isJs = false)
    {
        if (!$isJs) {
            header("Location: $url");
            die();
        } else {
            die("<script>location.href.assign('$url')</script>");
        }
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessFilter::className()
            ] // 过滤器

        ];
    }

    //导出csv
    public function export_csv($filename,$str)
    {
        header("Content-type:text/csv");  
        header("Content-Disposition:attachment;filename=".$filename);  
        header('Cache-Control: max-age=0');  
        header('Expires:0');  
        header('Pragma:public');  
        echo($str);
    }
}
