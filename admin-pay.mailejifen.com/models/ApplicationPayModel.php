<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_application".
 *
 * @property integer $id
 * @property string $name
 * @property string $key
 * @property string $secret
 * @property tinyint $status
 */
class ApplicationPayModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_application';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'key', 'secret', 'status'], 'required'],
            [['status'], 'integer'],
            [['name', 'key', 'secret'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => '应用名称',
            'key' => 'key',
            'secret' => 'secret',
            'status' => '状态'
        ];
    }

    
}
