<?php
namespace app\logics;

use app\logics\BaseLogic;
use app\models\RechargeOrderModel;
use app\models\MerchantModel;
use BaseComponents\exceptions\AppException;
use app\components\ErrorCode;
use app\components\OrderHelper;
use app\components\LoginHelper;
use yii;

class RechargeOderLogic extends BaseLogic
{
    /**内部充值
     * @param $data
     * @return bool
     * @throws AppException
     */
    public function create($data)
    {
        $data['pay_amount'] *= 100;
        $data['recharge_amount'] *= 100;

        $merchant = MerchantModel::getOneByEmailAndLock($data['email']);
        if (!$merchant) {
            throw new AppException(ErrorCode::ERR_NO_DATA, '商户不存在');
        }
        $order = new RechargeOrderModel();
        $order->attributes = $data;
        $order->order_sn = OrderHelper::getSn();
        $order->merchant_id = $merchant['id'];
        $order->balance = $merchant['balance'] + $order->recharge_amount;
        $order->operator_id = LoginHelper::$admin_id;
        $order->pay_type = RechargeOrderModel::PAY_TYPE_ADMIN;
        $order->complete_time = date('Y-m-d H:i:s');
        $order->status = RechargeOrderModel::STATUS_COMPLETED;

        if ($order->save()) {
            MerchantModel::recharge($merchant['id'], $order->recharge_amount, '后台充值', $order->order_sn,$type='2');
            return true;
        } else {
            throw new AppException(ErrorCode::ERR_PARAM, '', $order->getErrors());
        }
    }

    /**充值订单列表
     * @param $page
     * @param $pageSize
     * @param $search
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getList($page, $pageSize, $search)
    {

        $offset = ($page - 1) * $pageSize;
        $where = ' where a.status = '.RechargeOrderModel::STATUS_COMPLETED;

        if (!empty($search['orderSn'])) {
            $where .= " and a.order_sn = '{$search['orderSn']}'";
        }
        if (!empty($search['merchantEmail'])) {
            $where .= " and b.email = '{$search['merchantEmail']}'";
        }
        if ($search['startTime'] != '' && $search['endTime'] != '') {
            $startTime = $search['startTime'] . ' 00:00:00';
            $endTime = $search['endTime'] . ' 23:59:59';
            $where .= " and a.create_time >= '$startTime' and a.create_time <= '$endTime'";
        }
        if ($search['payType'] != '') {
            $where .= " and a.pay_type2 = '{$search['payType']}'";
        }
        $where .= " order by a.id desc limit {$offset},{$pageSize}";
        $sql = "SELECT a.*,b.email 
                FROM credits_recharge_order as a 
                LEFT JOIN credits_merchant as b 
                ON a.merchant_id = b.id" . $where;

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /** 充值订单总记录数
     * @param $search
     * @return int|string
     */
    public function countOrder($search)
    {
        $where = ' where a.status = '.RechargeOrderModel::STATUS_COMPLETED;
        if (!empty($search['orderSn'])) {
            $where .= " and a.order_sn = '{$search['orderSn']}'";
        }
        if (!empty($search['merchantEmail'])) {
            $where .= " and b.email = '{$search['merchantEmail']}'";
        }
        if ($search['startTime'] != '' && $search['endTime'] != '') {
            $startTime = $search['startTime'] . ' 00:00:00';
            $endTime = $search['endTime'] . ' 23:59:59';
            $where .= " and a.create_time >= '$startTime' and a.create_time <= '$endTime'";
        }
        if ($search['payType'] != '') {
            $where .= " and a.pay_type2 = '{$search['payType']}'";
        }
        $sql = "SELECT count(1) as c 
                FROM credits_recharge_order as a 
                LEFT JOIN credits_merchant as b 
                ON a.merchant_id = b.id" . $where;

        $count = Yii::$app->db->createCommand($sql)->queryOne();

        return $count['c'];
    }

    /**总计金额
     * @param $search
     * @return mixed
     */
    public function getPriceTotal($search)
    {

        $where = ' where a.order_sn = a.order_sn';
        if (!empty($search['orderSn'])) {
            $where .= " and a.order_sn = '{$search['orderSn']}'";
        }
        if (!empty($search['merchantEmail'])) {
            $where .= " and b.email = '{$search['merchantEmail']}'";
        }
        if ($search['startTime'] != '' && $search['endTime'] != '') {
            $startTime = $search['startTime'] . ' 00:00:00';
            $endTime = $search['endTime'] . ' 23:59:59';
            $where .= " and a.create_time >= '$startTime' and a.create_time <= '$endTime'";
        }
        if ($search['payType'] != '') {
            $where .= " and a.pay_type2 = '{$search['payType']}'";
        }

        $sql = "SELECT SUM(a.recharge_amount) as t 
                FROM credits_recharge_order as a 
                LEFT JOIN credits_merchant as b 
                ON a.merchant_id = b.id" . $where;

        $total = Yii::$app->db->createCommand($sql)->queryOne();

        return $total['t'];
    }
}

?>