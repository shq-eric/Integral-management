<?php
namespace app\controllers;

use BaseComponents\base\Login;
use yii;
use app\models\AdminUserModel;
use app\components\CoreHelper;
use app\components\Operation;

class SiteController extends BaseController
{

    public function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        $this->redirect('/platform/list');
    }

    public function actionLogin()
    {
        if (YII_DEBUG == false) {
            Login::getInstance()->run();
            $this->redirect('index');
        } else {
            if (Yii::$app->request->isPost) {

                $username = Yii::$app->request->post('username');
                $password = Yii::$app->request->post('password');

                $admin = AdminUserModel::getByUsername($username);
                if (!$admin || $admin->password !== md5($password . $admin->salt)) {
                    exit('<h2>用户名或密码错误!</h2>');
                }
                
                $this->storeLoginSession($admin);
                
                $admin->login_time = CURRENT_DATETIME;
                $admin->login_ip = CoreHelper::newRealIp();
                $admin->login_count++;
                $admin->save();
                
                Operation::setLoginStatus($admin);
                
                $admin = AdminUserModel::findOne([
                    'username' => $username
                ]);
                $this->redirect('index');
            } else {
                $this->display('site/login');
            }
        }
    }


    /**保存登录session
     * @param $admin
     */
    private function storeLoginSession($admin)
    {
        $_SESSION['admin_id'] = $admin->id;
        $_SESSION['admin'] = $admin->attributes;
    }
    
    /**
     * 退出登录
     */
    public function actionLogout()
    {
        session_destroy();
        $this->redirect('login');
    }
}
