<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\StatisticsDataModel;
use app\models\AppSettingModel;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    public $collectionName = 'credits_statistics';
    private $collection;

    public function actionIndex()
    {
        $Mongo = new \MongoClient('mongodb://credits:mongodbyy1024@120.76.152.62:27017/credits');
        $db = $Mongo->credits;
        $collection = $db->credits_statistics;

        exec("/sh/statistask2.sh todaytotalpv", $result);
        exec("/sh/statistask2.sh todaytotaluv", $result1);
        
        $tmp = [];
        foreach ($result as $k => $v) {
            $v = explode(' ', $v);
            $tmp[$v[1]] = $v[0];
        }

        $totalpv = $tmp;
        foreach ($result1 as $value) {
            $value = explode(' ', $value);
            if (preg_match("/^[a-z\d]{24}$/i", $value[1])) {
                $tmps[] = $value[1];
            }
        }

        $totaluv = array_count_values($tmps);

        $collection->remove([
            'task_id' => 6,
            'interval_type' => 1,
            'time' => date('Y-m-d', strtotime('-1 day')),
        ]);

        foreach ($totaluv as $k => $v) {
            $insertData = [
                'task_id' => 6,
                'task_identifier' => 'getpv',
                'interval_type' => 1,
                'app_key' => $k,
                'output' => ['pv' => floatval($totalpv[$k]), 'uv' => floatval($v)],
                'time' => date('Y-m-d', strtotime('-1 day')),
                'create_time' => date('Y-m-d H:i:s', time())
            ];
            $collection->insert($insertData);
        }
    }
}
