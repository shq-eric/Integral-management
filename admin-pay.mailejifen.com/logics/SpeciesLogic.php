<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/4/12
 * Time: 下午3:42
 */
namespace app\logics;

use Yii;
use app\models\SpeciesModel;

class SpeciesLogic extends BaseLogic
{
    public function init()
    {
        parent::init();
    }

    public function setSpeciesToGoods($speciesIds, $goodsId)
    {
        SpeciesModel::clearGoodsSpecies($goodsId);
        SpeciesModel::batchGoodsSpeciesAdd($speciesIds, $goodsId);
    }

}