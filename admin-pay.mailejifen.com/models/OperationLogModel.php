<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%operation_log}}".
 *
 * @property integer $id
 * @property integer $operation_merchant_id
 * @property string $operation_ip
 * @property string $operation_route
 * @property string $operation_description
 * @property string $operation_time
 */
class OperationLogModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{admin_operation_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operation_merchant_id'], 'integer'],
            [['operation_description', 'operation_time'], 'required'],
            [['operation_description'], 'string'],
            [['operation_time'], 'safe'],
            [['operation_ip'], 'string', 'max' => 15],
            [['operation_route'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'operation_merchant_id' => 'Operation Merchant ID',
            'operation_ip' => 'Operation Ip',
            'operation_route' => 'Operation Route',
            'operation_description' => 'Operation Description',
            'operation_time' => 'Operation Time',
        ];
    }


    //日志列表
    public function getList($search,$page, $pageSize)
    {
        $where = 'operation_merchant_id=operation_merchant_id';
        if($search['id'] !=''){
           $where .=" and operation_merchant_id='{$search['id']}'";
        }
        if($search['content'] !=''){
            $where .=" and operation_description like '%{$search['content']}%'";
        }

        if($search['startTime'] !='' && $search['endTime'] !=''){

            $start = $search['startTime'].' 00:00:00';
            $end = $search['endTime'].' 23:59:59';
            $where .=" and operation_time >='{$start}' and operation_time<= '{$end}'";

        }

        return self::find()->orderBy('operation_time desc')
            ->where($where)
            ->limit($pageSize)
            ->offset(($page - 1) * $pageSize)
            ->all();
    }

    public function getCount($search)
    {
        $where = 'operation_merchant_id=operation_merchant_id';
        if($search['id'] !=''){
            $where .=" and operation_merchant_id='{$search['id']}'";
        }
        if($search['content'] !=''){
            $where .=" and operation_description like '%{$search['content']}%'";
        }
        if($search['startTime'] !='' && $search['endTime'] !=''){
            $start = $search['startTime'] .' 00:00:00';
            $end = $search['endTime'] .' 23:59:59';
            $where .=" and operation_time >='{$start}' and operation_time<='{$end}'";
        }
        return self::find()->where($where)->count(1);
    }
}
