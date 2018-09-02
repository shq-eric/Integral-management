<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/20 0020
 * Time: 16:51
 */
namespace app\logics;

use app\components\ErrorCode;
use app\models\NoticeModel;
use app\models\MerchantModel;
use app\models\NoticeMerchantModel;
use BaseComponents\exceptions\AppException;

class NoticeLogic extends BaseLogic
{

   

    public function add($data)
    {
         $transaction = \Yii::$app->db->beginTransaction();
         $notice=new NoticeModel();
         $notice->attributes=$data;
         $notice->create_time = CURRENT_DATETIME;
         $notice->type=NoticeModel::TYPE_COMMON;

         if($notice->save()){
            $id = $notice->attributes['id'];
            //写入到关系表
            $list=MerchantModel::find()->select('id')->all();
            if(!empty($list)){
                foreach ($list as $key => $val) {
                    $d['merchant_id']=$val['id'];
                    $d['nid']=$id;
                    $d['is_read']=0;
                    $d['create_time']=CURRENT_DATETIME;
                    $d['read_time']='';
                    $model_notice_merchant=new NoticeMerchantModel();
                    $model_notice_merchant->add($d);
                    unset($d);
                }
            }
            $transaction->commit();
            return true;
        } else {
            $transaction->rollBack();
            throw new AppException(ErrorCode::ERR_PARAM, '', $spu->getErrors());
        }
    }

}
