<?php
namespace app\components;

use Yii;
use BaseComponents\exceptions\AppException;
use app\models\AdminUserModel;

/**
 * 登录帮助类
 * 获取当前登录商户信息
 * @author Nekoing
 *
 */
class LoginHelper 
{
    static public $admin_id = null;
    
    static private $admin = null;
    
    /**
     * 获得当前登录的管理员ID
     * @return Integer
     */
    static public function getAdminId() {
        return self::$admin_id;
    }
    
    /**
     * TODO 改为getUserInfo，实现用户信息会话保存
     * 获得当前登录的商户AR
     * @return AdminUserModel
     */
    static public function getAdmin()
    {
        if(! self::$admin && self::$admin_id) {
            self::$admin = AdminUserModel::findOne(self::$admin_id);
        }
    
        return self::$admin;
    }


    /**
     * 判断用户是否登录
     * @param bool $break
     * @return bool
     * @throws AppException
     */
    static public function checkLogin($break = true)
    {
        if(self::$admin_id) {
            return true;
        }
        else {
            if($break === true) {
                $domain = Yii::$app->params['domain'];
                header("Location: $domain");
                exit();
            }
            else {
                throw new AppException(9999);
            }
        }
    }
}