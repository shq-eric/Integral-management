<?php
namespace app\controllers;

use app\models\ThirdPayAccountModel;
use BaseComponents\exceptions\AppException;
use app\components\ErrorCode;
use app\components\Utils;
use app\models\PlatformModel;
use app\models\PlatformAccountModel;
use app\models\MailePayOrderModel;
use app\models\ThirdPayOrderModel;
use app\models\RefundOrderModel;
use app\models\ApplicationPayModel;

class PlatformController extends BaseController
{
    public function actionThirdAccount()
    {
        $list = ThirdPayAccountModel::find()->with('boundPlatforms')->all();
        
        foreach ($list as &$item) {
            $item->account_type = ThirdPayAccountModel::getAccountTypeName($item['account_type']);
        }

        $this->display('third-account', [
            'list' => $list
        ]);
    }
    
    public function actionAddThirdAccount()
    {
        if(\Yii::$app->request->isPost) {
            if(ThirdPayAccountModel::findOne([
                'account' => $this->request('account'),
                'account_type' => $this->request('account_type')
            ])) {
                throw new AppException(ErrorCode::ERR_PARAM, "该账户已存在");
            }
            
            $account = new ThirdPayAccountModel();
            $account->attributes = $this->request();
            $account->data = $_POST['data'];
            if($account->save()) {
                $this->success("操作成功", '/platform/third-account');
            }
            else {
                throw new AppException(ErrorCode::ERR_PARAM, '', $account->errors);
            }
        }
        else {
            $this->display('edit-third-account', [
                'model' => null
            ]);
        }
    }
    
    public function actionEditThirdAccount()
    {
        $id = $this->request('id');
        
        $account = ThirdPayAccountModel::findOne($id);
        if(! $account) {
            throw new AppException(ErrorCode::ERR_NO_DATA);
        }
        
        if(\Yii::$app->request->isPost) {
            $old = ThirdPayAccountModel::findOne([
                'account' => $this->request('account'),
                'account_type' => $this->request('account_type')
            ]);
            if($old && $old->id != $id) {
                throw new AppException(ErrorCode::ERR_PARAM, "该账户已存在");
            }
            
            $account->attributes = $this->request();
            $account->data = $_POST['data'];
            if($account->save()) {
                $this->success("操作成功", '/platform/third-account');
            }
            else {
                throw new AppException(ErrorCode::ERR_PARAM, '', $account->errors);
            }
        }
        else {
            $this->display('edit-third-account', [
                'model' => $account
            ]);
        }
    }
    
    public function actionList()
    {
        $list = PlatformModel::find()->all();
    
        $this->display('list', [
            'list' => $list,
            'accountTypeMap' => ThirdPayAccountModel::getAccountTypeName()
        ]);
    }
    

    public function actionEdit()
    {
        $id = $this->request('id');
        $platform = PlatformModel::findOne($id);
        if(\Yii::$app->request->isPost) {
            $name = $this->request('name');
            
            $platform->name = $name;
            $platform->save();
            
            $this->redirect('/platform/list');
        }
        else {
            $this->display('edit', [
                'model' => $platform
            ]);
        }
    }
    
    public function actionAdd()
    {
        if(\Yii::$app->request->isPost) {
            $platformIdent = $this->request('platform');
            $name = $this->request('name');
    
            $old = PlatformModel::find()
                ->where(['name' => $name])
                ->orwhere(['platform' => $platformIdent])
                ->one();
            if($old) {
                throw new AppException(ErrorCode::ERR_PARAM, '该平台已存在');
            }

            //平台添加
            $platform = new PlatformModel();
            $platform->platform = $platformIdent;
            $platform->name = $name;
            $platform->save();

            //应用添加
            do {
                $key = Utils::genRandStr(32);
            }while(ApplicationPayModel::findOne(['key' => $key]));
            
            do {
                $secret = Utils::genRandStr(32);
            }while(ApplicationPayModel::findOne(['secret' => $secret]));
            $application = new ApplicationPayModel();
            $application->name = $name;
            $application->status = 0;
            $application->key = $key;
            $application->secret = $secret;
            $application->save();
    
            $this->redirect('/platform/list');
        }
        else {
            $this->display('edit', [
                'model' => null
            ]);
        }
    }
    
    public function actionPlatformAccountBind()
    {
        $id = $this->request('id');
        $platform = PlatformModel::findOne($id);
        if(! $platform) {
            throw new AppException(ErrorCode::ERR_NO_DATA);
        }
        
        $_boundAccounts = $platform->boundAccounts;
        $allAccounts = ThirdPayAccountModel::find()->asArray()->all();
        $availableAccounts = [];
        
        $allAccounts = array_column($allAccounts, null, 'id');

        $boundAccounts = [];
        foreach ($_boundAccounts as $account) {
            $data = $account->attributes;
            $data['account_type'] = ThirdPayAccountModel::getAccountTypeName($data['account_type']);
            $boundAccounts[] = $data;
            
            $allAccounts[$account->id]['bound'] = true;
        }
        foreach ($allAccounts as &$account) {
            $account['account_type'] = ThirdPayAccountModel::getAccountTypeName($account['account_type']);
            if(empty($account['bound'])) {
                $account['bound'] = false;
            }
            echo $account['bound'] ? 'Y' : 'N';
        }
        
        usort($allAccounts, function($a, $b) {
            if($a['bound'] == $b['bound']) {
                if($a['account_type'] == $b['account_type']) {
                    return $a['id'] > $b['id'] ? 1 : -1;
                }
                else {
                    return strcasecmp($a['account_type'], $b['account_type']);
                }
            }
            else {
                return $a['bound'] ? -1 : 1;
            }
        });
        
        $this->display('platform-account-bind', [
            'model' => $platform,
            'list' => $allAccounts,
            'boundAccounts' => $boundAccounts
        ]);
    }
    
    public function actionDoBind()
    {
        $platformId = $this->request('platformId');
        $bindAccountId = $this->request('accountId');
        
        $platform = PlatformModel::findOne($platformId);
        $bindAccount = ThirdPayAccountModel::findOne($bindAccountId);
        if(!$platform || !$bindAccount) {
            throw new AppException(ErrorCode::ERR_NO_DATA);
        }
        
        $boundAccounts = $platform->boundAccounts;
        foreach ($boundAccounts as $account) {
            if($account->account_type == $bindAccount->account_type) {
                $r = PlatformAccountModel::find()->where([
                    'platform_id' => $platform->id,
                    'account_id' => $account->id
                ])->one();
                $r && $r->delete();
                break;
            }
        }
        $relation = new PlatformAccountModel();
        $relation->account_type = $bindAccount->account_type;
        $relation->account_id = $bindAccount->id;
        $relation->platform = $platform->platform;
        $relation->platform_id = $platform->id;
        $relation->save();
        
        $this->redirect('/platform/platform-account-bind?id=' . $platform->id);
    }
    
    public function actionDoUnbind()
    {
        $platformId = $this->request('platformId');
        $unbindAccountId = $this->request('accountId');
        
        $platform = PlatformModel::findOne($platformId);
        $r = PlatformAccountModel::find()->where([
            'platform_id' => $platform->id,
            'account_id' => $unbindAccountId
        ])->one();
        $r && $r->delete();
        
        $this->redirect('/platform/platform-account-bind?id=' . $platform->id);
    }
}

?>