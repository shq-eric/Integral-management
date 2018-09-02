<?php
/**
 * Created by PhpStorm.
 * User: @Faith
 * Date: 2016/4/28 0028
 * Time: 10:45
 */
namespace app\logics;

use app\components\OrderFactory;
use app\models\OrderDealViewModel;
use app\models\OrderModel;
use app\models\RechargeOrderModel;

class OrderLogic extends BaseLogic
{

    public function init()
    {
        parent::init();
        $this->model = new OrderDealViewModel();
    }

    /**获取订单列表
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getOrderList($page, $pageSize, $category, $search, $deliverStatus = '')
    {
        $model = OrderFactory::getInstance($category);
        if ($deliverStatus) {
            $search['status'] = $deliverStatus;
        }

        return $model->getOrderList($page, $pageSize, $category, $search);

    }

    /**获取分类订单条数
     * @return int|string
     */
    public function getCount($category, $search, $deliverStatus = '')
    {
        $model = OrderFactory::getInstance($category);
        if ($deliverStatus) {
            $search['status'] = $deliverStatus;
        }
        return $model->getCounts($category, $search);
    }

    /**获取待处理订单
     */
    public function getDeal($page, $pageSize, $search)
    {
        return $this->model->getDeal($page, $pageSize, $search);
    }

    /**待处理订单总条数
     */
    public function getDealCount($search)
    {
        return $this->model->getDealCount($search);
    }

    public function getException($page, $pageSize, $search)
    {
        return $this->model->getException($page, $pageSize, $search);

    }

    public function getExceptionCount($search)
    {
        return $this->model->getExceptionCount($search);
    }

}