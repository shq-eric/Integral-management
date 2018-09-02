<?php
/**
 * Created by PhpStorm.
 * User: Faith
 * Date: 2016/6/12 0012
 * Time: 16:08
 */

namespace app\logics;

use app\components\ErrorCode;
use app\models\AppThemeModel;
use app\models\MerchantModel;
use BaseComponents\exceptions\AppException;

class GuiLogic extends BaseLogic
{
    /**主题列表
     * @param $page
     * @param $pageSize
     */
    public function getThemeList($page, $pageSize)
    {
        return AppThemeModel::find()
            ->limit($pageSize)
            ->offset(($page - 1) * $pageSize)
            ->all();

    }

    /**
     * 主题总记录条数
     */
    public function getThemeCount()
    {

        return AppThemeModel::find()->count(1);
    }

    /**新增
     * @param $data
     * @return bool
     * @throws AppException
     */
    public function add($data)
    {

        $themeModel = new AppThemeModel();
        $themeModel->theme_name = $data['theme_name'];
        $themeModel->theme_alias = $data['theme_alias'];
        $themeModel->view_type = $data['view_type'];
        $themeModel->create_time = date('Y-m-d H:i:s');
        if ($themeModel->save()) {
            
            return true;
        } else {
            throw new AppException(ErrorCode::ERR_PARAM, '', $themeModel->getErrors());
        }

    }


    /**
     * 编辑
     */

    public function edit($id, $data)
    {

        $themeModel = AppThemeModel::findOne($id);
        if (!$themeModel) {
            throw new AppException(ErrorCode::ERR_PARAM);
        }
        $themeModel->theme_name = $data['theme_name'];
        $themeModel->theme_alias = $data['theme_alias'];
        $themeModel->view_type = $data['view_type'];

        if ($themeModel->save()) {
            return true;
        } else {
            throw new AppException(ErrorCode::ERR_PARAM, '', $themeModel->getErrors());
        }

    }
}