<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_notify_log".
 *
 * @property integer $id
 * @property string $type
 * @property string $method
 * @property string $uri
 * @property string $body
 * @property string $client_ip
 * @property string $create_time
 */
class NotifyLogModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_notify_log';
    }
}
