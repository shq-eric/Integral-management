<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_third_order".
 *
 * @property integer $id
 * @property string $maile_pay_sn
 * @property string $third_pay_sn
 * @property string $order_sn
 * @property string $pay_type
 * @property string $pay_client_type
 * @property string $attach
 * @property string $send_time
 * @property string $pay_time
 * @property string $pay_amount
 * @property string $notify_time
 * @property string $notify_raw
 * @property string $pay_state
 * @property string $refunded_amount
 * @property string $error_msg
 */
class ThirdPayOrderModel extends \yii\db\ActiveRecord
{
    /*
    SUCCESS—支付成功
    REFUND—转入退款
    NOTPAY—未支付
    CLOSED—已关闭
    REVOKED—已撤销（刷卡支付）
    USERPAYING--用户支付中
    PAYERROR--支付失败(其他原因，如银行返回失败)
    */
    const PAY_STATE_SUCCESS = 'SUCCESS';
    const PAY_STATE_REFUND = 'REFUND';
    const PAY_STATE_NOTPAY = 'NOTPAY';
    const PAY_STATE_CLOSED = 'CLOSED';
    const PAY_STATE_REVOKED = 'REVOKED';
    const PAY_STATE_USERPAYING = 'USERPAYING';
    const PAY_STATE_PAYERROR = 'PAYERROR';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_third_order';
    }

    public static function getAllStatus()
    {
        return self::find()->select('pay_state')->distinct()->all();
    }
    
    public static  function getAllPayType()
    {
        return self::find()->select('pay_type')->distinct()->all();
    }
    
    public static function getThirdList($search, $page, $pageSize, $action='list')
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
                $andWhere = " send_time >= '{$sTime}' and send_time <= '{$eTime}'";
            }

            if ($search['maile_pay_sn'] != '') {
                $where['maile_pay_sn'] = $search['maile_pay_sn'];
            }
            if ($search['third_pay_sn'] != '') {
                $where['third_pay_sn'] = $search['third_pay_sn'];
            }
            if ($search['pay_type'] != '') {
                $where['pay_type'] = $search['pay_type'];
            }
            if ($search['pay_state']) {
                $where['pay_state'] = $search['pay_state'];
            }
        }
        if($action == 'csv'){
            return self::find()
            ->where($where)->andWhere($andWhere)->orderBy('id desc')->all();
        }
        return self::find()
            ->where($where)->andWhere($andWhere)
            ->orderBy('id desc')
            ->limit($pageSize)
            ->offset(($page - 1) * $pageSize)
            ->all();
    }

    public static function getThirdCount($search)
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
                $andWhere = " send_time >= '{$sTime}' and send_time <= '{$eTime}'";
            }

            if ($search['maile_pay_sn'] != '') {
                $where['maile_pay_sn'] = $search['maile_pay_sn'];
            }
            if ($search['third_pay_sn'] != '') {
                $where['third_pay_sn'] = $search['third_pay_sn'];
            }
            if ($search['pay_type'] != '') {
                $where['pay_type'] = $search['pay_type'];
            }
            if ($search['pay_state']) {
                $where['pay_state'] = $search['pay_state'];
            }
        }
        return self::find()->where($where)->andWhere($andWhere)->count(1);
    }
}
