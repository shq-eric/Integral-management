<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/2/25
 * Time: 下午2:36
 */
namespace app\logics;

use app\models\GoodsCategoryModel;
use app\models\GoodsRulesModel;
use Yii;
use app\logics\BaseLogic;
use app\models\GoodsSpuModel;

class SpuLogic extends BaseLogic
{
    public function init()
    {
        $this->model = new GoodsSpuModel();
    }
    
    /**
     * @param $id
     */
    public function getOneSpu($id)
    {
        $spu = $this->model->getSpuByConditions(['id'=>$id]);
        if($spu) {
            //获取分类名称
            $goodsCategoryModel = new GoodsCategoryModel();
            $categoryName = $goodsCategoryModel->getOneCategoryByConditions(['id'=>$spu['spu_category_id']],'category_name');
            $spu['category_name'] = $categoryName['category_name'];
            //获取规则
            $goodsRuleModel = new GoodsRulesModel();
            $spu['rule'] = $goodsRuleModel->getOneRulebyConditions(['id'=>$spu['spu_rule_id']]);
            //Todo 获取图片
            $spu['img'] = [];
        }
        return $spu;
    }
    
    public function getAppSpuList($appId, $search, $page, $pageSize)
    {
        $where = [
            'and',
            ['app_id' => $appId],
            ['!=', 'status', GoodsSpuModel::STATUS_DELETED]
        ];
        if(isset($search['name'])) {
            $where[] = ['spu_name' => $search['name']];
        }
        
        
        $spus = GoodsSpuModel::find()
            ->where($where)
            ->offset(($page - 1) * $pageSize)
            ->limit($pageSize)
            ->with('prototype')
            ->all();
        return $spus;
    }
    
    public function getAppSpuCount($appId, $search)
    {
        $where = [
            'and',
            ['app_id' => $appId],
            ['!=', 'status', GoodsSpuModel::STATUS_DELETED]
        ];
        if(isset($search['name'])) {
            $where[] = ['spu_name' => $search['name']];
        }
    
        $count = GoodsSpuModel::find()
        ->where($where)
        ->count(1);
        return $count;
    }
    
    public function getRuleTree()
    {
        $tree = [];
        $categories = GoodsCategoryModel::find()->all();
        
        foreach ($categories as $key => $category)
        {
            $tree[$key] = $category->attributes;
            $tree[$key]['children'] = [];
            $rules = $category->rules;
            foreach ($rules as $rule)
            {
                $tree[$key]['children'][] = $rule->attributes;
            }
        }
        return $tree;
    }
}