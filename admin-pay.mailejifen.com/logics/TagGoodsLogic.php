<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/4/12
 * Time: 下午3:42
 */
namespace app\logics;

use Yii;
use app\models\TagGoodsModel;
use yii\base\Exception;

class TagGoodsLogic extends BaseLogic
{
    public function init()
    {
        parent::init();
        $this->model = new TagGoodsModel();
    }

    public function deleteTagsByGoodsId($goodsId)
    {
        return $this->model->deleteAll(['goods_id'=>$goodsId]);
    }


    public function addTags($tagIds,$goodsId)
    {
        if(count($tagIds) > 5) {
            throw new Exception(91002);
        }

        $this->model->deleteAll(['goods_id'=>$goodsId]);
        if(is_array($tagIds)) {
            foreach($tagIds as $v) {
                $this->_addTag($v,$goodsId);
            }
        }
        else {
            $this->_addTag($tagIds,$goodsId);
        }
    }

    private function _addTag($tagId,$goodsId)
    {
        $this->model->tag_id = $tagId;
        $this->model->goods_id = $goodsId;
        $this->model->isNewRecord = true;
        return $this->model->save();
    }

}