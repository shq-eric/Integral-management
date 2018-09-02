<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_user_log".
 *
 * @property integer $id
 * @property integer $operation_admin_id
 * @property string $operation_ip
 * @property string $operation_route
 * @property string $operation_description
 * @property string $operation_time
 */
class UserLogModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operation_admin_id'], 'integer'],
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
            'id' => '操作记录id',
            'operation_admin_id' => '操作用户id',
            'operation_ip' => '操作ip',
            'operation_route' => '路由',
            'operation_description' => '操作详情',
            'operation_time' => '操作时间',
        ];
    }


    //日志列表
    public function getList($search,$page, $pageSize)
    {
        $where = 'operation_admin_id=operation_admin_id';
        if($search['id'] !=''){
            $where .=" and operation_admin_id='{$search['id']}'";
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
        $where = 'operation_admin_id=operation_admin_id';
        if($search['id'] !=''){
            $where .=" and operation_admin_id='{$search['id']}'";
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
