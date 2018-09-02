<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $realname
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $phone
 * @property integer $creator_id
 * @property integer $status
 * @property string $login_time
 * @property string $login_ip
 * @property integer $login_count
 * @property string $create_time
 * @property string $group
 * @property string $member_num
 */
class AdminUserModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{admin_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'realname', 'password', 'group'], 'required'],
            [['creator_id', 'status', 'login_count', 'member_num'], 'integer'],
            [['login_time', 'create_time'], 'safe'],
            [['username', 'realname', 'password', 'group'], 'string', 'max' => 32],
            [['salt'], 'string', 'max' => 5],
            [['email'], 'string', 'max' => 64],
            [['phone'], 'string', 'max' => 16],
            [['login_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '管理员ID',
            'username' => '用户名',
            'realname' => '真实姓名',
            'password' => '密码',
            'salt' => 'salt',
            'email' => '邮箱',
            'phone' => '电话',
            'creator_id' => '创建人ID',
            'status' => '状态',
            'login_time' => '最后登录时间',
            'login_ip' => '最后登录IP',
            'login_count' => '登录次数',
            'create_time' => '创建时间',
            'group' => '用户组',
            'member_num' => '员工编号'
        ];
    }

    //获取账户
    static public function getByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    public function getGroupName()
    {
        return $this->hasOne(AdminAuthItemModel::className(), ['name' => "group"])->select("description");
    }
}
