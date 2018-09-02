<?php

namespace app\controllers;

use Yii;
use BaseComponents\exceptions\AppException;
use app\components\ErrorCode;
use app\components\PageHelper;

use app\models\MailePayOrderModel;
use app\models\ThirdPayOrderModel;
use app\models\RefundOrderModel;

class OrderController extends BaseController
{	
    protected $status_array = array(
        0 => '已创建', 
        1 => '支付中',
        9 => '已支付',
        20 => '支付失败',
        30 => '支付已关闭'
    );

    protected $refund_status_array = array(
        9 => '退款成功',
        10 => '退款失败'
    );

    public function actionMailePayOrder()
    {
    	$page = new PageHelper();
    	$querys = $this->request();
        $page_start = $this->request('page',1);
        //$this->getPage($querys);
        $platform = MailePayOrderModel::getAllPlatform();
        $status = MailePayOrderModel::getAllStatus();
        $pay_type = MailePayOrderModel::getAllPayType();
        $platform_array = $this->platformArray();
        //var_dump($platform_array);die;
        $order = MailePayOrderModel::getMaileList($querys,$page_start,$this->pageSize);
        $count = MailePayOrderModel::getMaileCount($querys);

	    $html = $page->html('/order/maile-pay-order',$count,$this->pageSize,$querys);
	    
        $this->display('maile-pay-order', [
            'order' => $order,
            'html' => $html,
            'platform' =>$platform,
            'platform_array' => $platform_array,
            'status' => $status,
            'pay_type' => $pay_type,
            'status_array' => $this->status_array
	       ]);
    }

    //退款订单	
    public function actionRefundOrder()
    {
    	$page = new PageHelper();
        $querys = $this->request();
        $page_start = $this->request('page',1);
        // $page_start = $this->getPage($querys);
        $status = RefundOrderModel::getAllStatus();
        $refund_reason = RefundOrderModel::getAllRefundReason();

        $order = RefundOrderModel::getRefundList($querys,$page_start,$this->pageSize);
        $count = RefundOrderModel::getRefundCount($querys);

        $html = $page->html('/order/refund-order',$count,$this->pageSize,$querys);

        $this->display('refund-order', [
            'order' => $order,
            'html' => $html,
            'status' => $status,
            'refund_reason' => $refund_reason,
            'refund_status_array' => $this->refund_status_array
            ]); 
    }

    //第三方订单
    public function actionThirdPayOrder()
    {
    	$page = new PageHelper();
        $querys = $this->request();
        $page_start = $this->request('page',1);
        $pay_state = ThirdPayOrderModel::getAllStatus();
        $pay_type = ThirdPayOrderModel::getAllPayType();

        $order = ThirdPayOrderModel::getThirdList($querys,$page_start,$this->pageSize);
        $count = ThirdPayOrderModel::getThirdCount($querys);

       	$html = $page->html('/order/third-pay-order',$count,$this->pageSize,$querys);
       	$this->display('third-pay-order', [
        	'order' => $order,
        	'html' => $html,
            'pay_state' => $pay_state,
            'pay_type' => $pay_type
        ]);	
    	
    }

    //整理数据导出

    public function actionMaileExportCsv()
    {
        $querys = $this->request();
        $page_start = $this->request('page',1);
        $result = MailePayOrderModel::getMaileList($querys,$page_start,$this->pageSize,'csv');
        //数据不能为空
        $this->isResEmpty($result);

	    $str = "麦乐支付序列号,商品订单号,购买平台,充值方式,充值金额,支付客户端类型,充值状态,币种,创建时间\n";  
	    $str = iconv('utf-8','gb2312',$str);  
	    foreach ($result as $key => $row) {
	    	$status = iconv('utf-8','gb2312',$row['status']); //中文转码   

	        $str .= $row['maile_pay_sn'].",".$row['order_sn'].","
            .$row['platform'].",".$row['pay_type'].",".number_format($row['pay_amount']/100,2).",".$row['pay_client_type'].",".$status.",".$row['fee_type'].
	        ",".$row['create_time']."\n"; //用引文逗号分开  
	    }
	    $filename = '麦乐订单'.date('Ymdhms').'.csv'; //设置文件名  

	    $this->export_csv($filename,$str); //导出
    }

    public function actionRefundExportCsv()
 	{
 		$querys = $this->request();
        $page_start = $this->request('page',1);
        $result = RefundOrderModel::getRefundList($querys,$page_start,$this->pageSize,'csv');
        //数据不能为空
        $this->isResEmpty($result);

	    $str = ",麦乐支付序列号,退款序列号,退款原因,退款金额,退款状态,创建时间\n";  
	    $str = iconv('utf-8','gb2312',$str);  
	    foreach ($result as $key => $row) { 	
	        $str .= $row['maile_pay_sn'].",".$row['maile_refund_sn'].",".
	        iconv('utf-8','gb2312',$row['refund_reason']).",".number_format($row['refund_amount']/100,2).",".
	        $row['status'].",".
	        $row['create_time']."\n"; //用引文逗号分开  
	    }
	    $filename = '退款订单'.date('Ymdhms').'.csv'; //设置文件名  
	    $this->export_csv($filename,$str); //导出
 	}

    public function actionThirdExportCsv()
    {
    	$querys = $this->request();
        $page_start = $this->request('page',1);
        $result = ThirdPayOrderModel::getThirdList($querys,$page_start,$this->pageSize,'csv');
        //数据不能为空
        $this->isResEmpty($result);

	    $str = "麦乐支付序列号,第三方支付序列号,充值方式,充值金额,充值状态,创建时间\n";  
	    $str = iconv('utf-8','gb2312',$str);  
	    foreach ($result as $key => $row) { 	
	        $str .= $row['maile_pay_sn'].",".$row['third_pay_sn'].",".$row['pay_type'].",".number_format($row['pay_amount']/100,2).",".$row['pay_state'].",".$row['send_time']."\n"; //用引文逗号分开  
	    }
	    $filename = '第三方支付订单'.date('Ymdhms').'.csv'; //设置文件名  
	    $this->export_csv($filename,$str); //导出 
    }

    public function platformArray()
    {
        $array = MailePayOrderModel::getPlatformArray();
        return $array;
    }

    public function isResEmpty($result)
    {
        if(empty($result)){
            echo "<script>alert('导出数据不能为空！');
            location.href='".$_SERVER["HTTP_REFERER"]."'
            </script>";
            die;
        }
    }
}