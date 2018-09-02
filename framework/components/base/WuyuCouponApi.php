<?php
namespace BaseComponents\base;

use app\components\ErrorCode;
use BaseComponents\exceptions\AppException;
use yii\helpers\VarDumper;

/**
 * Class WuyuCouponApi
 * @package BaseComponents\base
 */
class WuyuCouponApi
{

    const API_GOODS_INFO = 'http://www.wy20.com.cn/api/outside_infoquery_api.asp';

    const API_GETCARD = 'http://www.wy20.com.cn/api/outside_getcard_api.asp';

    private static $buynumber = 1;

    private static $key = 'kasdfkl3yiotqwio5ydf';

    private static $merchantid = 134730;

    public static function getCouponList()
    {
    }

    /**发起接口调用，获取卡券号码
     * @param $wuyuCouponModel
     * @param $order_sn
     * @return array
     */
    public static function getOneCoupon($wuyuCouponModel, $order_sn)
    {
        $params = [
            'merchantid' => self::$merchantid,
            'action' => 'product',
            'productid' => $wuyuCouponModel->wuyu_product_id,
            'sign' => md5('product' . self::$merchantid . $wuyuCouponModel->wuyu_product_id . self::$key),
        ];


        $xmlStr = Http::run(self::API_GOODS_INFO, $params, Http::GET, true);
        $data = json_decode(json_encode((array)simplexml_load_string($xmlStr)), true);

        if ((int)$data['queryresult']['resultcode'] === 0) {
            if (!empty($data['productlists']['productlist'])) {
                $purchase = sprintf("%1.2f", $data['productlists']['productlist']['purchase']);

            } else {
                return [
                    'code' => 401,
                    'msg' => '第三方接口数据异常'
                ];
            }

        } else {
            return [
                'code' => $data['queryresult']['resultcode'],
                'msg' => $data['queryresult']['resultdescription']
            ];
        }

        $params = [
            'merchantid' => self::$merchantid,
            'productid' => $wuyuCouponModel->wuyu_product_id,
            'buynumber' => self::$buynumber,
            'saleprice' => $purchase,
            'orderno' => $order_sn,
            'sign' => md5(self::$buynumber . self::$merchantid . $order_sn . $wuyuCouponModel->wuyu_product_id . $purchase . self::$key),
        ];

        try {
            $xmlStr1 = Http::run(self::API_GETCARD, $params, Http::GET, true);

            $response = json_decode(json_encode((array)simplexml_load_string($xmlStr1)), true);


            \Yii::warning('[wuyu coupon] request:' . self::API_GETCARD . '; params: ' . json_encode($params) . ' response:' . json_encode($response));

            if ((int)$response['traderesult']['resultcode'] === 0) {

                if ($response['cardlists'] && isset($response['cardlists']['cardlist'])) {
                    $card = $response['cardlists']['cardlist'];
                    $couponSn = base64_decode($card['cardno']);
                    $couponPwd = base64_decode($card['cardpassword']);

                    return [
                        'code' => 0,
                        'data' => [
                            'coupon_sn' => $couponSn,
                            'coupon_pwd' => $couponPwd
                        ]
                    ];
                }
            } else {
                return [
                    'code' => $response['traderesult']['resultcode'],
                    'msg' => $response['traderesult']['resultdescription']
                ];
            }
        } catch (\Exception $e) {
            \Yii::error('error:' . $e->getMessage());
            return [
                'code' => 999,
                'msg' => $e->getMessage()
            ];
        }
    }


}

