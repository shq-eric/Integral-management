<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_platform_account".
 * 
 * @property integer $platform_id
 * @property string $platform
 * @property integer $account_id
 * @property string $account_type
 */
class PlatformAccountModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_platform_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform_id', 'account_id'], 'required'],
            [['account_id'], 'integer'],
            [['platform', 'account_type'], 'string', 'max' => 32]
        ];
    }
}
