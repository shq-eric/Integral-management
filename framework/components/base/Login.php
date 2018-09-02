<?php
/**
 * Created by PhpStorm.
 * User: @Faith
 * Date: 2016-11-01
 * Time: 10:24
 */
namespace BaseComponents\base;

use app\components\ErrorCode;
use app\components\MaileApiClient;
use app\models\AdminUserModel;
use BaseComponents\exceptions\AppException;
use BaseComponents\extensions\oauth\Oauth;
use BaseComponents\extensions\oauth\Token;
use yii\console\Exception;
use yii\helpers\Json;

class Login
{
    private $key = '';
    private $secret = '';
    private static $instance;

    static public function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function run()
    {
        $this->key = \Yii::$app->params['oauthKey'];
        $this->secret = \Yii::$app->params['oauthSecret'];

        $this->checkAccess();
        $this->checkUser();

    }

    private function checkAccess()
    {
        $params = \Yii::$app->request->get();
        if (!isset($params['source'])) {
            throw new AppException(ErrorCode::ERR_NO_ACCESS);
        }

        $url = Oauth::getTargetRequsetUrl($this->key, $this->secret, $params['source']);//sso.mailejifen.com
        if (!$url) {
            \Yii::warning('[Oauth] request:' . $params['source'] . '; params: ' . json_encode($params) . ' response:' . json_encode($url));
            exit('Params Fail');
        }
        $domainHash = substr(md5($params['source'] . $_SERVER['HTTP_HOST']), 8, 16);

        $redisKey = "ML_token:{$domainHash}";

        $token = \Yii::$app->redis->get($redisKey);

        if (!$token) {

            $token = MaileApiClient::getInstance()->call($url, [], 'post', false, false);
            #设置缓存
            \Yii::$app->redis->set($redisKey, $token['token'], $token['expire']);
        }


        try {
            Token::validator($token, $params);
        } catch (\Exception $e) {
            \Yii::warning('[Oauth] request:' . $params['source'] . '; params: ' . json_encode($params) . ' response:' . json_encode($url));
            var_dump($e->getMessage());
            exit;
        }
    }

    private function checkUser()
    {
        $membernum = \Yii::$app->request->get('membernum');
        $realname = \Yii::$app->request->get('realname');
        $username = \Yii::$app->request->get('username');
        $role = \Yii::$app->request->get('role');

        if (!$membernum) {
            throw new AppException(ErrorCode::ERR_PARAM);
        }

        $admin = AdminUserModel::find()->where(['member_num' => $membernum])->one();

        if (!$admin) {
            $model = new AdminUserModel();
            $model->member_num = $membernum;
            $model->username = $username;
            $model->password = md5('maile_123456');
            $model->realname = $realname;
            $model->login_ip = CoreHelper::newRealIp();
            $model->group = $role == 1 ? 'admin' : 'test';
            $model->create_time = CURRENT_DATETIME;
            if (!$model->save()) {
                throw new AppException(ErrorCode::CREATE_USER_FAIL, '', $model->getErrors());
            }
            $this->saveSession($model);
        } else {
            $admin->login_ip = CoreHelper::newRealIp();
            $admin->login_count++;
            $admin->login_time = CURRENT_DATETIME;
            $admin->save();
            $this->saveSession($admin);
        }

    }

    private function saveSession($admin)
    {
        $_SESSION['admin_id'] = $admin->id;
        $_SESSION['admin'] = $admin->attributes;
    }


}