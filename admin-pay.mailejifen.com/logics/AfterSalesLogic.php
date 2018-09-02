<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/2/25
 * Time: 下午2:36
 */
namespace app\logics;

use Yii;
use app\logics\BaseLogic;
use app\models\AfterSalesModel;

class AfterSalesLogic extends BaseLogic
{

    public function init()
    {
        $this->model = new AfterSalesModel();
    }

    public function getDealingList($page, $pageSize, $search)
    {
        $where = $this->buildWhere($search);
        $where[] = [
            'status' => [
                AfterSalesModel::STATUS_CREATED,
                AfterSalesModel::STATUS_WAIT_GOODS,
                AfterSalesModel::STATUS_WAIT_REVIEW,
                AfterSalesModel::STATUS_REVIEWED
            ]
        ];

        $list = AfterSalesModel::find()->where($where)
            ->offset(($page - 1) * $pageSize)
            ->limit($pageSize)
            ->all();

        return $list;
    }

    public function getDealingCount($search)
    {
        $where = $this->buildWhere($search);
        $where[] = [
            'status' => [
                AfterSalesModel::STATUS_CREATED,
                AfterSalesModel::STATUS_WAIT_GOODS,
                AfterSalesModel::STATUS_WAIT_REVIEW,
                AfterSalesModel::STATUS_REVIEWED
            ]
        ];

        return AfterSalesModel::find()->where($where)->count();
    }

    public function getList($page, $pageSize, $search)
    {
        $where = $this->buildWhere($search);

        $list = AfterSalesModel::find()->where($where)
            ->offset(($page - 1) * $pageSize)
            ->limit($pageSize)
            ->orderBy('create_time desc')
            ->all();

        return $list;
    }

    public function getCount($search)
    {
        $where = $this->buildWhere($search);

        return AfterSalesModel::find()->where($where)->count();
    }

    public function buildWhere($search)
    {
        $where = [
            'and'
        ];

        if (isset($search['orderSn']) && $search['orderSn']) {
            $where[] = [
                'order_sn' => $search['orderSn']
            ];
        }

        if (isset($search['platform']) && $search['platform']) {
            $where[] = [
                'platform' => $search['platform']
            ];
        }

        if (isset($search['status']) && $search['status'] != -1) {
            $where[] = [
                'status' => $search['status']
            ];
        }

        if (isset($search['startTime']) && $search['startTime']) {
            $where[] = [
                '>=',
                'create_time',
                $search['startTime'] . ' 00:00:00'
            ];
        }

        if (isset($search['endTime']) && $search['endTime']) {
            $where[] = [
                '<=',
                'create_time',
                $search['endTime'] . ' 23:59:59'
            ];
        }

        return $where;
    }
}