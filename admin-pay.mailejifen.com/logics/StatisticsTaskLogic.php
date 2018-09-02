<?php
namespace app\logics;

use Yii;
use BaseComponents\exceptions\AppException;
use app\components\ErrorCode;
use app\models\StatisticsTaskModel;
use app\models\StatisticsDataModel;

class StatisticsTaskLogic extends BaseLogic
{

    public function getList($page, $pageSize)
    {
        return StatisticsTaskModel::find()->limit($pageSize)
            ->offset(($page - 1) * $pageSize)
            ->all();
    }

    public function count()
    {
        return StatisticsTaskModel::find()->count(1);
    }

    public function add($data)
    {
        $data['on_daily'] = isset($data['on_daily']) ? $data['on_daily'] : 0;
        $data['on_monthly'] = isset($data['on_monthly']) ? $data['on_monthly'] : 0;
        $data['on_yearly'] = isset($data['on_yearly']) ? $data['on_yearly'] : 0;
        $data['use_count'] = isset($data['use_count']) ? $data['use_count'] : 0;
        
        $task = new StatisticsTaskModel();
        $task->attributes = $data;
        if ($task->save()) {
            return true;
        } else {
            throw new AppException(ErrorCode::ERR_PARAM, '', $task->getErrors());
        }
    }

    public function edit($id, $data)
    {
        $data['on_daily'] = isset($data['on_daily']) ? $data['on_daily'] : 0;
        $data['on_monthly'] = isset($data['on_monthly']) ? $data['on_monthly'] : 0;
        $data['on_yearly'] = isset($data['on_yearly']) ? $data['on_yearly'] : 0;
        $data['use_count'] = isset($data['use_count']) ? $data['use_count'] : 0;
        
        $task = StatisticsTaskModel::findOne($id);
        if (! $task) {
            throw new AppException(ErrorCode::ERR_NO_DATA);
        }
        
        $task->attributes = $data;
        if ($task->save()) {
            return true;
        } else {
            throw new AppException(ErrorCode::ERR_PARAM, '', $task->getErrors());
        }
    }

    /**
     * 统计数据并入库
     * @param unknown $date
     * @param string $task
     * @throws AppException
     */
    public function statistics($date, $task = null)
    {
        $stime = microtime(true);
        
        $date = date('Y-m-d', strtotime($date));
        $yesterday = date('Y-m-d', strtotime($date . ' -1 day'));
        $lastMonth = date('Y-m', strtotime(substr($date, 0, 7) . '-01 -1 day'));
        $lastYear = date('Y', strtotime(substr($date, 0, 4) . '-01-01 -1 day'));
        
        $isMonthStart = preg_match('/-0?1$/', $date);
        $isYearStart = preg_match('/-0?1-0?1$/', $date);
        
        if (! $task) {
            $tasks = StatisticsTaskModel::findAll([
                'status' => StatisticsTaskModel::STATUS_NORMAL
            ]);
        } else {
            $task = StatisticsTaskModel::findOneByIdentifier($task);
            if (! $task) {
                throw new AppException(ErrorCode::ERR_NO_DATA);
            }
            $tasks = [
                $task
            ];
        }
        
        foreach ($tasks as $task) {
            $sstime = microtime(true);
            try {
                $dataModel = $task->getDataModel();
                
                if ($task->on_daily) {
                    $datas = $task->statisticsDay($yesterday);
                    echo $task->getLastSql() . '<br/>';
                    if ($datas) {
                        $dataModel->addDatas(StatisticsDataModel::INTERVAL_TYPE_DAILY, $yesterday, $datas);
                    }
                }
                
                if ($task->on_monthly && $isMonthStart) {
                    $datas = $task->aggregateMonth($lastMonth);
                    if ($datas) {
                        $dataModel->addDatas(StatisticsDataModel::INTERVAL_TYPE_MONTHLY, $lastMonth, $datas);
                    }
                }
                
                if ($task->on_yearly && $isYearStart) {
                    $datas = $task->aggregateYear($lastYear);
                    if ($datas) {
                        $dataModel->addDatas(StatisticsDataModel::INTERVAL_TYPE_YEARLY, $lastYear, $datas);
                    }
                }
            } catch (\PDOException $e) {
                \Yii::error("[statistics task -- $date] [identifier: " . $task->identifier . '] ' . $e->getMessage());
            }
            $eetime = microtime(true);
            echo "## Task $task->identifier completed. runtime " . round($eetime - $sstime, 3) . "s  -- $date.<br/>";
        }
        
        $etime = microtime(true);
        echo '## All task completed, runtime: ' . round($etime - $stime, 3) . "s  -- $date.<br/><br/>";
    }
}
?>