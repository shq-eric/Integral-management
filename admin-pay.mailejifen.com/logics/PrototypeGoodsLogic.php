<?php
namespace app\logics;

use app\models\GoodsDisableModel;
use Yii;
use BaseComponents\exceptions\AppException;
use app\logics\BaseLogic;
use app\models\PrototypeGoodsModel;
use app\models\GoodsRulesModel;
use app\models\ImgDetailModel;
use app\components\ErrorCode;
use app\models\GoodsThroughSpuModel;

class PrototypeGoodsLogic extends BaseLogic
{


    public function getListForShelve($page, $pageSize, $stock, $min_price, $max_price, $goods_name, $prototypeGoodsId, $speciesId, $orderSn)
    {
        return PrototypeGoodsModel::getListForShelve($page, $pageSize, $stock, $min_price, $max_price, $goods_name, $prototypeGoodsId, $speciesId, $orderSn);
    }

    public function countForShelves($stock, $min_price, $max_price, $goods_name, $prototypeGoodsId, $speciesId, $orderSn)
    {
        return PrototypeGoodsModel::countForShelves($stock, $min_price, $max_price, $goods_name, $prototypeGoodsId, $speciesId, $orderSn);
    }

    public function checkSpuisCopy($protoGoods)
    {
        $data = [];
        if (!empty($protoGoods)) {
            foreach ($protoGoods as $v) {
                $ids[] = $v['id'];
            }


            $inThrough = GoodsThroughSpuModel::find()
                ->where(['and',
                    ['!=', 'status', GoodsThroughSpuModel::STATUS_DELETED],
                    ['in', 'prototype_goods_id', $ids]
                ])->asArray()->all();

            $inThrough = array_column($inThrough, 'status', 'prototype_goods_id');

        }
        foreach ($protoGoods as $k => $v) {

            $data[$k] = $v->attributes;
            $data[$k]['tags'] = $v->tags;
            $data[$k]['inThrough'] = isset($inThrough[$v['id']]) ? true : false;
        }

        return $data;

    }

    public function setDisable($id, $data)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $protoModel = PrototypeGoodsModel::findOne($id);
        $protoModel->status = PrototypeGoodsModel::STATUS_DISABLED;
        if ($protoModel->save()) {
            $disable = GoodsDisableModel::findOne($id);
            if ($disable) {
                $disable->delete();
            }
            //更改spu商品的状态为已失效
            $sql = "update credits_goods_spu set status=" . PrototypeGoodsModel::STATUS_INVALID . " 
                    where prototype_goods_id = {$id} 
                    and status !=" . PrototypeGoodsModel::STATUS_DELETED;
            Yii::$app->db->createCommand($sql)->execute();

            $model = new GoodsDisableModel();
            $model->goods_id = $id;
            $model->inner_cause_type = $data['inner_cause_type'];
            $model->inner_remark = $data['inner_remark'];
            $model->outer_cause_type = $data['outer_cause_type'];
            $model->outer_remark = $data['outer_remark'];
            $model->save();


            $transaction->commit();
            return true;

        } else {
            $transaction->rollBack();
            throw new AppException(ErrorCode::ERR_PARAM, '', $protoModel->getErrors());
        }


    }

    //设置spu商品为可启用状态
    public function setEnabled($id)
    {

        $sql = "update credits_goods_spu set status=" . PrototypeGoodsModel::STATUS_ENABLED . " 
                    where prototype_goods_id = {$id} 
                    and status !=" . PrototypeGoodsModel::STATUS_DELETED;
        return Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     *
     * @param unknown $data
     * @param GoodsRulesModel $rule
     */
    public function add($data, $rule, $detail)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data['description'] = htmlspecialchars_decode($data['description']);
        $goods = new PrototypeGoodsModel();
        $goods->attributes = $data;
        $goods->modify_time = date('Y-m-d H:i:s');
        $goods->price = round($data['price'] * 100);
        $goods->cost = round($data['cost'] * 100);

        if ($rule->rule_stock) {
            $goods->stock = $data['stock'];
        }

        $goods->category_id = $rule->rule_category_id;
        $goods->rule_id = $rule->id;

        $ruleLogic = new RuleLogic();
        if ($goods->save() && $ruleLogic->onSave($rule, $goods, $data, 'prototype', true)) {
            $transaction->commit();
            // 图片详情插入
            $id = $goods->attributes['id'];
            foreach ($detail as $v) {
                if (!strpos($v, 'add.jpg')) {
                    $imgModel = new ImgDetailModel();
                    $imgModel->proto_id = $id;
                    $imgModel->image_prototype_detail = $v;
                    $imgModel->save();
                } else {
                    unset($v);
                }
            }
            return $id;
        } else {
            $transaction->rollBack();
            throw new AppException(ErrorCode::ERR_PARAM, '', $goods->getErrors());
        }
    }

    public function edit($id, $detail, $NewImage, $image_id, $data)
    {
        $data['description'] = htmlspecialchars_decode($data['description']);
        $goods = PrototypeGoodsModel::findOne($id);
        $goods->attributes = $data;

        $goods->price = round($data['price'] * 100);

        $goods->cost = round($data['cost'] * 100);

        if ($goods->rule->rule_stock) {
            $goods->stock = $data['stock'];
        }

        $transaction = \Yii::$app->db->beginTransaction();
        $ruleLogic = new RuleLogic();
        if ($goods->save() && $ruleLogic->onSave($goods->rule, $goods, $data, 'prototype', false)) {

            $transaction->commit();
            $id = $goods->attributes['id'];
            // 删除
            if (!empty($image_id)) {
                foreach ($image_id as $v) {
                    $imgModel = ImgDetailModel::findOne($v);
                    $imgModel->delete();
                }
            }
            // 新增
            if (!empty($NewImage)) {
                foreach ($NewImage as $v) {
                    if (!strpos($v, 'add.jpg')) {
                        $imgadd = new ImgDetailModel();
                        $imgadd->proto_id = $id;
                        $imgadd->image_prototype_detail = $v;
                        $imgadd->save();
                    } else {
                        unset($v);
                    }
                }
            }
            // 更新
            if (!empty($detail)) {
                foreach ($detail as $k => $v) {
                    if (!strpos($v, 'add.jpg')) {
                        $img = ImgDetailModel::findOne($k);
                        $img->id = $k;
                        $img->image_prototype_detail = $v;
                        $img->save();
                    } else {
                        unset($v);
                    }
                }
            }
            return true;
        } else {
            throw new AppException(ErrorCode::ERR_PARAM, '', $goods->getErrors());
        }
    }

    public function getList($page, $pageSize)
    {
        return PrototypeGoodsModel::find()->limit($pageSize)
            ->offset(($page - 1) * $pageSize)
            ->orderBy('ID DESC')
            ->all();
    }

    public function getCount()
    {
        return PrototypeGoodsModel::find()->where([
            'status' => PrototypeGoodsModel::STATUS_NORMAL
        ])->count();
    }
}
