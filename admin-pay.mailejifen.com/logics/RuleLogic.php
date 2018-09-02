<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/2/26
 * Time: 下午2:54
 */
namespace app\logics;

use Yii;
use app\logics\BaseLogic;
use app\models\GoodsRulesModel;
use BaseComponents\exceptions\AppException;
use app\components\ErrorCode;
use app\components\Utils;
use app\models\ApplicationModel;

class RuleLogic extends BaseLogic
{
    public function init()
    {
        $this->model = new GoodsRulesModel();
    }

    /**
     * @param int $status
     * @return array
     * @throws AppException
     */
    public function options($status = GoodsRulesModel::STATUS_NORMAL)
    {
        $options = $this->model->getOptions($status);
        if(empty($options)) {
            throw new AppException(10003);
        }
        else {
            return array_column($options,'rule_name','id');
        }
    }

    //统计总记录
    public function count()
    {
        return GoodsRulesModel::find()->count();
    }

    /**
     * @param $page
     * @param $pageSize
     * @return mixed
     */
    public function getList($page, $pageSize)
    {
        $rules = GoodsRulesModel::find()
            ->limit($pageSize)
            ->offset(($page - 1) * $pageSize)
            ->orderBy('id desc')
            ->all();

        return $rules;
    }

    /**
     *
     * @param string $field
     * @param array $where
     * @return mixed
     */
    public function getCounts($field = '*' ,$where = [])
    {
        return $this->model->getCounts($field,$where);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOneRuleById($id)
    {
        return $this->model->getOneRulebyConditions(['id'=>$id]);
    }

    /**
     * @param $name
     * @param $status
     * @param $audit
     * @param $categoryId
     * @param $credit
     * @param $creditMoney
     * @param $virtual
     * @param $stock
     * @param $userLimit
     * @param $goodsLimit
     * @param $date
     * @param $level
     * @param $imageDetail
     * @param $imageThumbnail
     * @param $imageBanner
     * @param $imageIcon
     * @param $user
     * @return bool
     * @throws AppException
     */
    public function add($data)
    {
        $rule = new GoodsRulesModel();
        $rule->attributes = $data;
        if($rule->save()) {
            return true;
        }
        else {
            throw new Appexception(ErrorCode::ERR_PARAM, '', $rule->getErrors());
        }
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     * @throws AppException
     */
    public function edit($id, $data)
    {
        $rule = GoodsRulesModel::findOne($id);
        if(!$rule) {
            throw new AppException(ErrorCode::ERR_NO_DATA);
        }
        
        $rule->attributes = $data;
        if($rule->save()) {
            return true;
        }
        else {
            throw new AppException(ErrorCode::ERR_PARAM, '', $rule->getErrors());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id)
    {
        $rule = self::findOne($id);
        if($rule->deleteById()) {
            return true;
        }
        else {
            throw new AppException(10002);
        }
    }
    
    public function getRuleHtml($id, $spu = null, $scenario = 'shelves')
    {
        if(!is_object($id)) {
            $rule = GoodsRulesModel::findOne($id);
        }
        else{
            $rule = $id;
        }

        if(!$rule) {
            throw new AppException(ErrorCode::ERR_NO_DATA);
        }

        $html = '';
        $app = isset($_SESSION['appContext']) && $_SESSION['appContext'] ? 
        ApplicationModel::findOne($_SESSION['appContext']->id) : null;
        
        $ruleNames = $this->getRuleNames();

        foreach ($ruleNames as $ruleName) {
            $this->attachRule($html, $rule, $ruleName, $spu, $scenario, $app);
        }
        return $html;
    }
    
    public function onSave($id, $goods, $data, $scenario, $isNew)
    {
        if(!is_object($id)) {
            $rule = GoodsRulesModel::findOne($id);
        }
        else{
            $rule = $id;
        }
        
        if(!$rule) {
            throw new AppException(ErrorCode::ERR_NO_DATA);
        }
        
        $ruleNames = $this->getRuleNames();
        foreach ($ruleNames as $ruleName) {
            if($rule->{'rule_' . $ruleName})
            {
                $className = Utils::underline2hump($ruleName);
                $ruleClass = 'app\\rules\\'.$ruleName.'\\'.$className.'Rule';
                $class = null;
                if(class_exists($ruleClass)) {
                    $class = new $ruleClass();
                    if(!$class->onSave($goods, $data, $scenario, $isNew))
                    {
                        return false;
                    }
                }
            }
        }
        return true;
    }
    
    protected function getRuleNames()
    {
        $redisKey = 'adminRules';
        $ruleNames = \Yii::$app->redis->lRange($redisKey, 0, -1);

        if(! $ruleNames) {
            $ruleDir = dirname(__DIR__).'/rules';
            $handle = opendir($ruleDir);

            $ruleNames = [];
            while (( $dir = readdir ( $handle ) ) !== false)
            {
                if ( $dir != '.' && $dir != '..' && is_dir($ruleDir.'/'.$dir))
                {
                    \Yii::$app->redis->lPush($redisKey, $dir);
                    $ruleNames[] = $dir;
                }
            }
            \Yii::$app->redis->expire($redisKey, 86400);
        }
        return $ruleNames;
    }
    
    protected function attachRule(&$html, $rule, $name, $spu, $scenario, $app) {
        if($rule->{'rule_' . $name})
        {
            $html .= $this->renderRule($name, $spu, $scenario, $app);
        }
    }
    
    public function renderRule($rule, $spu, $scenario, $app) 
    {
        $className = Utils::underline2hump($rule);

        $ruleClass = 'app\\rules\\'.$rule.'\\'.$className.'Rule';
        $class = null;

        if(class_exists($ruleClass)) {
            
            $class = new $ruleClass();

            if(($scenario == 'shelves' && !$class->availableOnShelves) ||
                ($scenario == 'prototype' && !$class->availableOnPrototype) ||
                ($scenario == 'addself' && !$class->availableOnAddSelf) ) {
                return '';
            }

        }


        $merchant = $app ? $app->merchant : null;

        $data = $class ? $class->onDisplay($spu, $app, $merchant) : [];
        if(!$data) $data = [];
        
        $tplPath = dirname(__DIR__).'/rules/'.$rule.'/input.html';
        if(file_exists($tplPath)) {
            $data = array_merge($data, [
                'model' => $spu,
                'name' => 'spu_'.$rule
            ]);
            return \Yii::$app->smarty->fetch($tplPath, $data);
        }
    }
}