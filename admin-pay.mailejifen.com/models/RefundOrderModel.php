<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_refund".
 *
 * @property integer $id
 * @property string $maile_refund_sn
 * @property string $maile_pay_sn
 * @property string $third_pay_sn
 * @property integer $refunded_amount
 * @property integer $order_balance
 * @property string $refund_reason
 * @property integer $status
 * @property string $failed_message
 * @property string $create_time
 */
class RefundOrderModel extends \yii\db\ActiveRecord
{
    const STATUS_REFUND_OK = 9; //退款成功
    const STATUS_REFUND_FAILED = 10;  //退款失败
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_refund_order';
    }

    public static function getAllStatus()
    {
        $statusArray = array(
        '退款成功' => 9,
        '退款失败' => 10
        );
        return $statusArray;
    }

    public static function getAllRefundReason()
    {
        return self::find()->select('refund_reason')->distinct()->all();
    }

	public static function getRefundList($search, $page, $pageSize,$action='list')
    {
        $where = [];
        $andWhere = "";

        if(count($search)>1)
        {
            if ($search['start_time'] != '' || $search['end_time'] != '') {
                if($search['end_time'] == ''){
                    $search['end_time'] = date("Y-m-d");
                }
                $sTime = $search['start_time'] . ' 00:00:00';
                $eTime = $search['end_time'] . ' 23:59:59';
                $andWhere = " create_time >= '{$sTime}' and create_time <= '{$eTime}'";
            }

            if ($search['maile_pay_sn'] != '') {
                $where['maile_pay_sn'] = $search['maile_pay_sn'];
            }
            if ($search['maile_refund_sn'] != '') {
                $where['maile_refund_sn'] = $search['maile_refund_sn'];
            }
            if ($search['refund_reason'] != '') {
                $where['refund_reason'] = $search['refund_reason'];
            }
            if ($search['status']) {
                $where['status'] = $search['status'];
            }
        }
        if($action == 'csv'){
        	return self::find()
            ->where($where)->andWhere($andWhere)
            ->orderBy('id desc')
            ->all();
        }
        return self::find()
            ->where($where)->andWhere($andWhere)
            ->orderBy('id desc')
            ->limit($pageSize)
            ->offset(($page - 1) * $pageSize)
            ->all();
        
    }

    public static function getRefundCount($search)
    {
        $where = [];
        $andWhere = "";
        if(count($search)>1)
        {
            if ($search['start_time'] != '' || $search['end_time'] != '') {
                if($search['end_time'] == ''){
                    $search['end_time'] = date("Y-m-d");
                }
                $sTime = $search['start_time'] . ' 00:00:00';
                $eTime = $search['end_time'] . ' 23:59:59';
                $andWhere = " create_time >= '{$sTime}' and create_time <= '{$eTime}'";
            }

            if ($search['maile_pay_sn'] != '') {
                $where['maile_pay_sn'] = $search['maile_pay_sn'];
            }
            if ($search['maile_refund_sn'] != '') {
                $where['maile_refund_sn'] = $search['maile_refund_sn'];
            }
            if ($search['refund_reason'] != '') {
                $where['refund_reason'] = $search['refund_reason'];
            }
            if ($search['status']) {
                $where['status'] = $search['status'];
            }
        }
        return self::find()->where($where)->andWhere($andWhere)->count(1);
    }
}
