<?php

namespace app\models;

use Yii;
use app\models\PlatformModel;
/**
 * This is the model class for table "pay_maile_order".
 *
 * @property integer $id
 * @property string $maile_pay_sn
 * @property string $order_sn
 * @property string $platform
 * @property integer $third_pay_id
 * @property string $third_pay_sn
 * @property string $pay_type
 * @property string $pay_client_type
 * @property integer $pay_amount
 * @property string $pay_title
 * @property string $pay_remark
 * @property string $fee_type
 * @property string $notify_url
 * @property string $redirect_url
 * @property string $time_start
 * @property string $time_expire
 * @property integer $status
 * @property integer $is_refunded
 * @property integer $refunded_amount
 * @property string $create_time
 */
class MailePayOrderModel extends \yii\db\ActiveRecord
{
    const STATUS_CREATED = 0;   //已创建
    const STATUS_PAYING = 1;   //支付中
    const STATUS_PAID = 9;   //已支付
    const STATUS_FAILED = 20;   //支付失败
    const STATUS_CLOSED = 30;   //支付已关闭
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_maile_order';
    }
    

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'maile_pay_sn' => '麦乐支付序列号', 
            'order_sn' => '商品订单号',
            'platform' => '购买平台', 
            'pay_type' => '充值方式', 
            'pay_client_type' => '支付客户端类型',
            'pay_amount' => '充值金额', 
            'status' => '充值状态', 
            'fee_type' => '币种', 
            'create_time' => '创建时间', 
        ];
    }
    /**
     * 
     * @param unknown $orderSn
     * @return MailePayOrder
     */
    public static function getOneAndLock($mailePaySn)
    {
        $sql = 'SELECT 1 FROM ' . self::tableName() . " WHERE maile_pay_sn = '{$mailePaySn}' LIMIT 1 FOR UPDATE";
        self::getDb()->createCommand($sql)->query();
        
        return self::findOne([
            'maile_pay_sn' => $mailePaySn
        ]);
    }

    public static function getAllPlatform()
    {
        return self::find()->select('platform')->distinct()->all();
    }

    public static function getPlatformArray()
    {
        $r1 = PlatformModel::find()->select('platform')->column();
        $r2 = PlatformModel::find()->select('name')->column();
        return array_combine($r1,$r2);
    }

    public static  function getAllPayType()
    {
        return self::find()->select('pay_type')->distinct()->all();
    }

    public static function getAllStatus()
    {
        $statusArray = array(
        '已创建' => 0, 
        '支付中' => 1,
        '已支付' => 9,
        '支付失败' => 20,
        '支付已关闭' => 30
        );
        return $statusArray;
    }

    public static function getMaileList($search, $page, $pageSize,$action='list')
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
            if ($search['order_sn'] != '') {
                $where['order_sn'] = $search['order_sn'];
            }
            if ($search['platform'] != '') {
                $where['platform'] = $search['platform'];
            }
            if ($search['pay_type'] != '') {
                $where['pay_type'] = $search['pay_type'];
            }
            if ($search['pay_client_type'] != '') {
                $where['pay_client_type'] = $search['pay_client_type'];
            }
            if ($search['status'] != '') {
                $where['status'] = $search['status'];
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

    public static function getMaileCount($search)
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
            if ($search['order_sn'] != '') {
                $where['order_sn'] = $search['order_sn'];
            }
            if ($search['platform'] != '') {
                $where['platform'] = $search['platform'];
            }
            if ($search['pay_type'] != '') {
                $where['pay_type'] = $search['pay_type'];
            }
            if ($search['pay_client_type'] != '') {
                $where['pay_client_type'] = $search['pay_client_type'];
            }
            if ($search['status'] != '') {
                $where['status'] = $search['status'];
            }
        }
        return self::find()->where($where)->andWhere($andWhere)->count(1);
    }
}
