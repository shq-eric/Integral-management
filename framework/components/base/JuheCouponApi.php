<?php
namespace BaseComponents\base;

use app\components\OrderHelper;
use BaseComponents\exceptions\AppException;

class JuheCouponApi
{

    const API_LIST = 'http://v.juhe.cn/giftCard/products';

    const API_DELIVERY = 'http://v.juhe.cn/giftCard/buy';

    private static $dataType = 'json';

    private static $key = '91d0d4ced85705e7ed38f792030c2c23';

    private static $openId = "JH29169946a5b160305ac295af4c079498";

    private static $user = 'riorio';

    public static function getCouponList()
    {
        $params = [
            'dtype' => self::$dataType,
            'key' => self::$key
        ];

        try {
            $response = Http::run(self::API_LIST, $params);

            if ($response['error_code'] === 0) {
                return $response['result'];
            } else {
                throw new AppException(416, $response['reason']);
            }
        } catch (\Exception $e) {

            throw new AppException(416, 'API接口调用失败');
        }
    }

    /**
     * 发起接口调用，获取卡券号码
     *
     * @param unknown $juheCouponId
     *            聚合卡券ID
     */
    public static function getCoupon($juheCouponId, $num = 1)
    {
        $userOrderId = OrderHelper::getSn();

        $sign = md5(self::$openId . self::$key . $num . $userOrderId);

        $params = [
            'dtype' => self::$dataType,
            'key' => self::$key,
            'num' => $num,
            'productId' => $juheCouponId,
            'userOrderId' => $userOrderId,
            'sign' => $sign
        ];

        try {
            $response = Http::run(self::API_DELIVERY, $params);

            // $response = json_decode('{"reason":"\u53d1\u8d27\u6210\u529f","result":{"juheOrderId":"JHDT201706061658330441860072","userOrderId":"201706061658068401","num":"1","deduction":17,"cards":[{"cardNo":"OnyoUxqVmwwJQP1UAg8aBQ==","cardPws":"GzaPt\/4Ypqrnip8YA1ege8qrj8gmTVst","expireDate":"20171231"}]},"error_code":0}', true);

            \Yii::warning('[juhe coupon] request:' . self::API_DELIVERY . '; params: ' . json_encode($params) . ' response:' . json_encode($response));
            if ($response['error_code'] === 0) {
                if ($response['result'] && isset($response['result']['cards'])) {
                    $cards = $response['result']['cards'];
                    $userKey = substr(str_pad(self::$user, 8, '0'), 0, 8);
                    $data = [];
                    foreach ($cards as $key => $value) {
                        $data[$key]['coupon_sn'] = self::decode($value['cardNo'], $userKey);
                        $data[$key]['coupon_pwd'] = self::decode($value['cardPws'], $userKey);
                        $data[$key]['expire_date'] = $value['expireDate'];
                        $data[$key]['price'] = $response['result']['deduction'] / $response['result']['num'];
                    }

                    return [
                        'code' => 0,
                        'data' => $data
                    ];
                }
            } else {
                return [
                    'code' => 999,
                    'msg' => "Juhe Api Return  errCode: " . $response['error_code'] . " errMsg: " . $response['reason'] . " juheCouponId: " . $juheCouponId
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

    /**
     * 加密
     * @param  string $str 待加密的字符串
     * @param  string $key 密码
     * @return string
     */
    public static function encode($str, $key)
    {
        $key = substr($key, 0, 8);
        $iv = $key;
        $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_ECB);
        $str = self::pkcs5Pad($str, $size);
        $s = mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB, $iv);
        return base64_encode($s);
    }

    /**
     * 解密
     * @param  string $str 待解密的字符串
     * @param  string $key 密码
     * @return string
     */
    public static function decode($str, $key)
    {
        $iv = $key;
        $str = base64_decode($str);
        $str = mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB, $iv);
        $str = self::pkcs5Unpad($str);
        return $str;
    }

    public static function pkcs5Pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public static function pkcs5Unpad($text)
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text))
            return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)
            return false;
        return substr($text, 0, -1 * $pad);
    }
}

