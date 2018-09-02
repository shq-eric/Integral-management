<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/20 0020
 * Time: 16:51
 */
namespace app\logics;

use app\components\ErrorCode;
use app\models\MerchantModel;
use BaseComponents\exceptions\AppException;

class MerchantLogic extends BaseLogic
{

    public function init()
    {
        parent::init();
        $this->model = new MerchantModel();
    }

    public function getList($search, $page, $pageSize)
    {
        $where = $this->parseSearch($search);

        return $this->model->getList($where, $page, $pageSize);
    }

    public function getCount($search)
    {
        $where = $this->parseSearch($search);

        return $this->model->getCount($where);
    }

    public function parseSearch($search)
    {
        $key = isset($search['key']) ? $search['key'] : null;
        $mark = isset($search['mark']) ? $search['mark'] : null;
        $where = [];
        if (!$mark && !$key) {
            $where[] = ['!=', 'merchant_mark', 4];
            return $where[0];
        }
        if ($key) {
            if (is_numeric($key)) {
                $where['id'] = $key;
            } else {
                $where['email'] = $key;
            }
        }
        return $where;
    }

    public function edit($id, $data)
    {
        $merchant = MerchantModel::findOne($id);
        $merchant->id = $id;
        $merchant->contacts = $data['contacts'];
        $merchant->merchant_name = $data['merchant_name'];
        $merchant->merchant_type = $data['merchant_type'];
        $merchant->area_code = $data['district'];
        $merchant->phone = $data['phone'];
        $merchant->status = $data['status'];
        $merchant->address = $data['address'];
        if ($merchant->save()) {
            return true;
        } else {
            throw new AppException(ErrorCode::ERR_PARAM);
        }
    }

}
