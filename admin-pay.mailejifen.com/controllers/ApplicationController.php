<?php
namespace app\controllers;

use app\components\Utils;
use app\components\ErrorCode;
use BaseComponents\exceptions\AppException;

use app\models\ApplicationPayModel;
use app\models\PlatformModel;

class ApplicationController extends BaseController
{
    public function actionList()
    {
        $list = ApplicationPayModel::find()->all();

        $this->display('list', [
            'list' => $list
        ]);
    }
    
    public function actionAdd()
    {
        if(\Yii::$app->request->isPost) {
            $platFormIdent = $this->request('platform');
            $name = $this->request('name');
            $status = $this->request('status');
            if(empty($name) || empty($platFormIdent)){
                $this->redirect('/application/add');
            }

            $old_application = ApplicationPayModel::findOne(['name' => $name]);
            if($old_application) {
                throw new AppException(ErrorCode::ERR_PARAM, '该应用已存在');
            }
            $old_platform = PlatformModel::findOne(['platform' => $platFormIdent]);
            //若有该平台 则不需添加平台
            if(!$old_platform) {
                $platform = new PlatformModel();
                $platform->platform = $platFormIdent;
                $platform->name = $name;
                $platform->save();
            }
            //设置key 和 secret
            do {
                $key = Utils::genRandStr(32);
            }while(ApplicationPayModel::findOne(['key' => $key]));
            
            do {
                $secret = Utils::genRandStr(32);
            }while(ApplicationPayModel::findOne(['secret' => $secret]));

            $application = new ApplicationPayModel();
            $application->name = $name;
            $application->key = $key;
            $application->secret = $secret;
            $application->status = $status;
            if(!$application->save()){
            var_dump($application->getErrors());die;
            }
            $this->redirect('/application/list');
        }
        else {
            $this->display('add', [
                'model' => null
            ]);
        }
    }


    public function actionEdit()
    {
        $id = $this->request('id');
        $application = ApplicationPayModel::findOne($id);
        
        if(\Yii::$app->request->isPost) {
            $name = $this->request('name');
            $status = $this->request('status');
            if(empty($name)){
               throw new AppException(ErrorCode::ERR_PARAM, '应用名称不能为空');
            } 
            $old = ApplicationPayModel::findOne(['name' => $name]);
            if($name!=$application['name'] && $old){
               throw new AppException(ErrorCode::ERR_PARAM, '应用名称已存在');
            }
            $application->name = $name;
            $application->status = $status;
            $application->save();
            $this->redirect('/application/list');
        }
        else {
            $this->display('edit', [
                'model' => $application
            ]);
        }
    }
}

?>