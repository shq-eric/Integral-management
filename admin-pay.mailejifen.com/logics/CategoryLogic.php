<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/2/24
 * Time: 上午11:28
 */
namespace app\logics;

use Yii;
use app\logics\BaseLogic;
use app\models\GoodsCategoryModel;
use BaseComponents\exceptions\AppException;
use app\components\ErrorCode;


class CategoryLogic extends BaseLogic
{
    public function init() {
        $this->model = new GoodsCategoryModel();
    }

    /**
     * 分类下拉
     * @param int $status
     * @return mixed
     * @throws Appexception
     */
    public function options($status = GoodsCategoryModel::STATUS_NORMAL)
    {
        $options = $this->model->getOptions($status);
        if(empty($options)) {
            throw new AppException(10003, '没有数据');
        }
        else {
            return array_column($options,'category_name','id');
        }
    }
    //统计总记录
    public function count()
    {
        return GoodsCategoryModel::find()->count();
    }

    /**
     * @param $page
     * @param $pageSize
     * @return mixed
     */
    public function getList($page, $pageSize)
    {
        $category = GoodsCategoryModel::find()
            ->limit($pageSize)
            ->offset(($page - 1) * $pageSize)
            ->orderBy('id desc')
            ->all();

        return $category;
    }
    /**
     *
     * @param $id
     * @return mixed
     */
    public function getOneCategoryById($id)
    {
        return $this->model->getOneCategoryByConditions(['id'=>$id]);
    }

    /**
     * 添加分类
     */
    public function add($data)
    {
        $category = new GoodsCategoryModel();
        $category->attributes = $data;
        
       if($category->save()) {
            return true;
        }
        else {
            throw new Appexception(ErrorCode::ERR_PARAM, '', $category->getErrors());
        }
    }

    /**
     * 修改分类
     */
    public function edit($id, $data)
    {
        if(!is_object($id))
        {
            $category = GoodsCategoryModel::findOne($id);
        }
        else {
            $category = $id;
        }
        
        $category->attributes = $data;
        
        if($category->save()) {
            return true;
        }
        else {
            throw new Appexception(ErrorCode::ERR_PARAM, '', $category->getErrors());
        }
    }

    /**
     * 删除分类
     * @param $id
     * @return bool
     * @throws Appexception
     */
    public function delete($id)
    {
        $result = $this->model->deleteById($id);
        if($result == true) {
            return true;
        }
        else {
            throw new Appexception(10000, '删除分类失败');
        }
    }
}