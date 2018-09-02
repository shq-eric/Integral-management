<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_third_pay_account".
 *
 * @property integer $id
 * @property string $tag
 * @property string $account_type
 * @property string $data
 * @property array $boundPlatforms
 */
class ThirdPayAccountModel extends \yii\db\ActiveRecord
{
    static private $accountTypes = [
        'alipay' => '支付宝',
        'weixin' => '微信',
        'iapppay' => '爱贝',
    ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_third_pay_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'account_type', 'data'], 'required'],
            [['data'], 'string'],
            [['account', 'account_type', 'description'], 'string', 'max' => 32]
        ];
    }

    public static function getAccountTypeName($type = '')
    {
        if($type) {
            return empty(self::$accountTypes[$type]) ? $type : self::$accountTypes[$type];
        }
        
        return self::$accountTypes;
    }
    
    public function getBoundPlatforms()
    {
        return $this->hasMany(PlatformModel::className(), ['id' => 'platform_id'])->viaTable(PlatformAccountModel::tableName(), ['account_id' => 'id']);
    }
}
