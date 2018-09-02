<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_account_bind".
 *
 * @property integer $account_id
 * @property string $platform
 * @property string $platform_desc
 * @property array $boundAccounts
 */
class PlatformModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_platform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform', 'name'], 'required'],
            [['platform', 'name'], 'string', 'max' => 32]
        ];
    }
    
    public function getBoundAccounts()
    {
        return $this->hasMany(ThirdPayAccountModel::className(), ['id' => 'account_id'])->viaTable(PlatformAccountModel::tableName(), ['platform_id' => 'id']);
    }
}
