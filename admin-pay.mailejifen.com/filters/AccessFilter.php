<?php
namespace app\filters;

use Yii;
use yii\base\ActionFilter;
use yii\helpers\Url;
use app\components\Utils;
use app\rbac\CheckRule;
use BaseComponents\exceptions\AppException;
use app\components\ErrorCode;

/**
 * 检查是否登录
 * 
 * @author Nekoing
 *        
 */
class AccessFilter extends ActionFilter
{
    // 在action之前运行，可用来过滤输入
    public function beforeAction($action)
    {
        $moduleId = $action->controller->module->id;
        
        $actionPath = ($moduleId == 'basic' ? '' : $moduleId . '/') . $action->controller->id . '/' . $action->id;
        
        if (in_array($actionPath, \Yii::$app->params['allowGuestAction'])) {
            return true;
        }
        
        if ($action->controller->isLogin()) {
            if( isset($_SESSION['admin']['group']) && $_SESSION['admin']['group'] == 'admin' ) {
                return true;
            }
            else {
                if (!CheckRule::can(Yii::$app->request->pathInfo)) {
                    throw new AppException(ErrorCode::NO_ACCESS);
                }
            }
            return true;
        }

        $currentUrl = Utils::getHttpScheme() . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $redirect = Url::to([
            '/site/login',
            'redirect' => $currentUrl
        ]);
        header('Location: ' . $redirect);
        die();
    }
}