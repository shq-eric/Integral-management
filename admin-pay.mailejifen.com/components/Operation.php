<?php
/**
 * Created by PhpStorm.
 * User: @Faith
 * Date: 2016/6/2 0002
 * Time: 16:51
 */
namespace app\components;

use app\models\UserLogModel;
use yii;
use yii\helpers\Url;
use app\components\LoginHelper;

class Operation
{
    /** insert操作之后触发此事件
     * @param $event
     */
    public static function add($event)
    {

        $admin = LoginHelper::getAdmin();
        if (!$admin || $event->sender->className() == UserLogModel::className()) {
            return true;
        }

        if (!empty($event->changedAttributes)) {
            $desc = '';
            $class = $event->sender->className();

            $model = new $class;
            $attr = $model->attributeLabels();

            foreach ($event->changedAttributes as $name => $value) {

                if (trim($value) != strip_tags($event->sender->getAttribute($name))) {
                    $lableName = isset($attr[$name]) ? $attr[$name] : $name;
                    $desc .= $lableName . ' : <label class="J_field">' . $value . '</label>  <label class="J_field">' . $event->sender->getAttribute($name) . '</label>,<br>';
                }
            }

            $desc = substr($desc, 0, -1);
            if (!$desc) {
                return true;
            }
            if ($class == 'app\models\GoodsDisableModel') {
                $id = $event->sender->goods_id;
            } else {
                if (!isset($event->sender->id)) {
                    $id = $event->sender->platform . "__" . $event->sender->account_id;
                } else {
                    $id = $event->sender->id;
                }

            }

            $route = Url::to();
            $operation = self::routeMap($route);
            $adminId = $admin->id;

            $description = <<<LABEL
 <a href="javascript: void(0);">$admin->realname</a> 添加了
 <label> $operation</label>
  <label class="m-mark">#$id </label><br/>$desc
LABEL;

            $data = [
                'operation_admin_id' => $adminId,
                'operation_ip' => $admin->login_ip,
                'operation_route' => $route,
                'operation_description' => $description,
                'operation_time' => date('Y-m-d H:i:s')
            ];

            $userLogModel = new UserLogModel();

            $userLogModel->attributes = $data;

            $params = [];
            $sql = Yii::$app->db->queryBuilder->insert(UserLogModel::tableName(),
                $data, $params);
            Yii::$app->db->createCommand($sql, $params)->execute();
        }

    }

    /** save操作之后触发此事件
     * @param $event
     * @return bool
     */
    public static function update($event)
    {

        $admin = LoginHelper::getAdmin();

        if (!$admin || $event->sender->className() == UserLogModel::className()) {
            return true;
        }
        if (!empty($event->changedAttributes)) {
            $desc = '';
            $class = $event->sender->className();


            $model = new $class;
            $attr = $model->attributeLabels();

            foreach ($event->changedAttributes as $name => $value) {

                if (trim($value) != strip_tags($event->sender->getAttribute($name))) {
                    $lableName = isset($attr[$name]) ? $attr[$name] : $name;
                    $desc .= $lableName . ' : <label class="J_field">' . $value . '</label> <i class="fa fa-angle-double-right"></i> <label class="J_field">' . $event->sender->getAttribute($name) . '</label>,<br>';
                }
            }

            $desc = substr($desc, 0, -1);
            if (!$desc) {
                return true;
            }
            if (!isset($event->sender->id)) {
                $id = $event->sender->tag_id;
            } else {
                $id = $event->sender->id;
            }

            $route = Url::to();
            $operation = self::routeMap($route);
            $adminId = $admin->id;

            $description = <<<LABEL
 <a href="javascript: void(0);">$admin->realname</a> 更新了
 <label> $operation</label>
  <label class="m-mark">#$id </label><br/>$desc
LABEL;

            $data = [
                'operation_admin_id' => $adminId,
                'operation_ip' => $admin->login_ip,
                'operation_route' => $route,
                'operation_description' => $description,
                'operation_time' => date('Y-m-d H:i:s')
            ];

            $userLogModel = new UserLogModel();
            $userLogModel->setAttributes($data);

            $userLogModel->save();


        }
    }

    /**设置商户登录时间及状态
     * @param $admin
     */
    public static function setLoginStatus($admin)
    {

        $data = [
            'operation_admin_id' => $admin->id,
            'operation_ip' => $admin->login_ip,
            'operation_route' => Url::to(),
            'operation_description' => '<a href="###">' . $admin->realname . '</a> 登录了管理后台',
            'operation_time' => date('Y-m-d H:i:s')
        ];

        $UserLogModel = new UserLogModel();
        $UserLogModel->setAttributes($data);
        $UserLogModel->save();
    }


    /**路由映射
     * @param $route
     * @return string
     */
    public static function routeMap($route)
    {
        $operation = '';
        switch ($route) {
            case (bool)strstr($route, '/platform/category/add'):
                $operation = '应用分类 <i class="fa fa-chevron-right"></i> 新增操作';
                break;
            case (bool)strstr($route, '/platform/category/edit'):
                $operation = '应用分类 <i class="fa fa-chevron-right"></i> 修改操作';
                break;
            case (bool)strstr($route, '/gui/add'):
                $operation = '界面配置 <i class="fa fa-chevron-right"></i> 新增操作';
                break;
            case (bool)strstr($route, '/gui/edit'):
                $operation = '界面配置 <i class="fa fa-chevron-right"></i> 修改操作';
                break;
            case (bool)strstr($route, '/merchant/edit'):
                $operation = '商户管理 <i class="fa fa-chevron-right"></i> 修改操作';
                break;
            case (bool)strstr($route, '/order/recharge'):
                $operation = '充值管理 <i class="fa fa-chevron-right"></i> 内部充值';
                break;
            case (bool)strstr($route, '/order/truck'):
                $operation = '待处理订单 <i class="fa fa-chevron-right"></i> 发货操作';
                break;
            case (bool)strstr($route, '/order/complete'):
                $operation = '待处理订单 <i class="fa fa-chevron-right"></i> 完成收货';
                break;
            case (bool)strstr($route, '/goods/tag/add'):
                $operation = '商品管理 <i class="fa fa-chevron-right"></i> 添加标签';
                break;
            case (bool)strstr($route, '/goods/tag/edit'):
                $operation = '商品管理 <i class="fa fa-chevron-right"></i> 修改标签';
                break;
            case (bool)strstr($route, '/goods/species/add'):
                $operation = '商品管理 <i class="fa fa-chevron-right"></i> 添加品类';
                break;
            case (bool)strstr($route, '/goods/species/edit'):
                $operation = '商品管理 <i class="fa fa-chevron-right"></i> 修改品类';
                break;
            case (bool)strstr($route, '/category/add'):
                $operation = '商品管理 <i class="fa fa-chevron-right"></i> 添加分类';
                break;
            case (bool)strstr($route, '/category/edit'):
                $operation = '商品管理 <i class="fa fa-chevron-right"></i> 修改分类';
                break;
            case (bool)strstr($route, '/rule/add'):
                $operation = '商品管理 <i class="fa fa-chevron-right"></i> 添加规则';
                break;
            case (bool)strstr($route, '/rule/edit'):
                $operation = '商品管理 <i class="fa fa-chevron-right"></i> 修改规则';
                break;
            case (bool)strstr($route, '/prototype-goods/add'):
                $operation = '商品管理 <i class="fa fa-chevron-right"></i> 添加商品';
                break;
            case (bool)strstr($route, '/prototype-goods/edit'):
                $operation = '商品管理 <i class="fa fa-chevron-right"></i> 修改商品';
                break;
            case (bool)strstr($route, '/statistics/add'):
                $operation = '统计任务 <i class="fa fa-chevron-right"></i> 添加任务';
                break;
            case (bool)strstr($route, '/statistics/edit'):
                $operation = '统计任务 <i class="fa fa-chevron-right"></i> 修改任务';
                break;
            default:
                $operation = '';
                break;
        }
        return $operation;

    }


}
