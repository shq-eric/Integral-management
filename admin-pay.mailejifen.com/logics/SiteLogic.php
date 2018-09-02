<?php
/**
 * Created by PhpStorm.
 * User: Faith
 * Date: 2016/3/25
 * Time: 15:17
 */
namespace app\logics;

use app\components\ErrorCode;
use app\components\Operation;
use app\components\CoreHelper;
use app\logics\BaseLogic;
use app\models\AdminUserModel;
use app\models\OperationLogModel;
use app\models\UserLogModel;
use BaseComponents\exceptions\AppException;

class SiteLogic extends BaseLogic
{
    public function init()
    {

        parent::init();
        $this->model = new OperationLogModel();
    }

    /**登录
     * @param $username
     * @param $password
     * @throws AppException
     */
    public function login($username, $password)
    {

        $admin = AdminUserModel::getByUsername($username);
        if (!$admin || $admin->password !== md5($password . $admin->salt)) {
            exit('<h2>用户名或密码错误!</h2>');
        }

        $this->storeLoginSession($admin);

        $admin->login_time = CURRENT_DATETIME;
        $admin->login_ip = CoreHelper::newRealIp();
        $admin->login_count++;
        $admin->save();

        Operation::setLoginStatus($admin);


    }

    /**保存登录session
     * @param $admin
     */
    private function storeLoginSession($admin)
    {
        $_SESSION['admin_id'] = $admin->id;
        $_SESSION['admin'] = $admin->attributes;
    }

    public function editPassword($data)
    {
        $adminModel = AdminUserModel::findOne($_SESSION['admin_id']);
        if ($adminModel) {
            if ($adminModel->password !== md5($data['oldPassword'])) {
                throw new AppException(ErrorCode::ERR_OLD_PASSWORD);
            }
            if ($data['newPassword'] !== $data['confirmPassword']) {
                throw new AppException(ErrorCode::ERR_INCONFORMITY_PASSWORD);
            }
            if ($data['newPassword'] == $data['oldPassword']) {
                throw new AppException(ErrorCode::ERR_BEFORE_PASSWORD);
            }


            $adminModel->password = md5($data['newPassword']);

            if ($adminModel->save()) {
                return true;
            } else {
                throw new AppException(ErrorCode::ERR_PARAM, '', $adminModel->getErrors());
            }
        } else {
            throw new AppException(ErrorCode::ERR_PARAM);
        }

    }


    /**日志列表
     * @param $search
     * @param $page
     * @param $pageSize
     * @return mixed.
     */
    public function getList($search, $site, $page, $pageSize)
    {
        if($site == 'merchant'){
           $model = new OperationLogModel(); 
        }
        if($site == 'admin'){
          $model = new UserLogModel();  
        }

        return $model->getList($search, $page, $pageSize);
    }

    /**获取总条数
     * @param $search
     * @return mixed
     */
    public function getCount($search, $site)
    {

        if($site == 'merchant'){
            $model = new OperationLogModel();
        }
        if($site == 'admin'){
            $model = new UserLogModel();
        }
        
        return $model->getCount($search);
    }


}
