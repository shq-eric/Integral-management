<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/5/18
 * Time: 下午3:13
 */
namespace app\rbac;

use Yii;
use yii\rbac\Rule;
use app\models\AdminAuthItemModel;


class CheckRule extends Rule
{

    public $name = "checkAccess";

    /**
     * @param int|string|\yii\rbac\Item $user
     * @param array|\yii\rbac\Item $item
     * @param array $params
     */
    public function execute($user, $item, $params)
    {
        $user = $this->getUserAccess();
        if(!empty($user)) {
            return in_array($item->name,$user) ? true : false;
        }
        else {
            return false;
        }
    }

    public static function can($item)
    {
        $user = self::getUserAccess();
        if(!empty($user)) {
            return in_array($item,$user) ? true : false;
        }
        else {
            return false;
        }
    }

    /**
     * 获取用户权限
     * @return array|bool
     */
    public static function getUserAccess()
    {
        if(isset($_SESSION['admin']['group']) && !empty($_SESSION['admin']['group'])) {
            $group = $_SESSION['admin']['group'];
            $group = AdminAuthItemModel::find()->where(['name'=>$group])->one();
            $access = [];
            if(!empty($group->authItemChildren)) {
                foreach($group->authItemChildren as $v) {
                    $access[] = $v->child;
                }
            }
            return $access;
        }
        else {
            return false;
        }
    }
}