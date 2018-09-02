<?php
namespace BaseComponents\base;

use BaseComponents\exceptions\AppException;

class JuheCouponApiBak
{

    const API_LIST = 'http://v.juhe.cn/giftCard/products';

    const API_DELIVERY = 'http://v.juhe.cn/giftCard/delivery';

    private static $dataType = 'json';

    private static $key = 'da04b0adeca52b11e1f15436f90dc9e3';

    private static $user = 'mailejifen';

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
    public static function getOneCoupon($juheCouponId)
    {
        $params = [
            'dtype' => self::$dataType,
            'key' => self::$key,
            'num' => 1,
            'productId' => $juheCouponId
        ];

        try {
            $response = Http::run(self::API_DELIVERY , $params);
            // $response = json_decode('{"reason":"\u53d1\u8d27\u6210\u529f","result":{"juheOrderId":"JHDN201606011445225295690087","num":"1","cards":[{"cardNo":"+nGAeyjz5xrw6CVVlSXPkSeoK8Jw292y","cardPws":"xg859YAznDm3bCBzcrmiNUJ1SulDcaBO","expireDate":"20190518"}]},"error_code":0}', true);
//          $response = json_decode('{"reason":"\u53d1\u8d27\u6210\u529f","result":{"juheOrderId":"JHDN201606011445231509870046","num":"1","cards":[{"cardNo":"P7xi73ANwoGXy+kSoI\/eYSeoK8Jw292y","cardPws":"gWjQ54EW\/2DKYDeEHBdnjKTdVlnagzFF","expireDate":"20190518"}]},"error_code":0}', true);
            \Yii::warning('[juhe coupon] request:' . self::API_DELIVERY . '; params: ' . json_encode($params) . ' response:' . json_encode($response));
            if ($response['error_code'] === 0) {
                if ($response['result'] && isset($response['result']['cards'])) {
                    $card = $response['result']['cards'][0];

                    $couponSn = self::decode($card['cardNo'], self::getCryptKey());
                    $couponPwd = self::decode($card['cardPws'], self::getCryptKey());

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
                    'code' => 999,
                    'msg' => $response['reason']
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
     *
     * @param string $str
     *            待加密的字符串
     * @param string $key
     *            密码
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
     *
     * @param string $str
     *            待解密的字符串
     * @param string $key
     *            密码
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
        return substr($text, 0, - 1 * $pad);
    }

    public static function getCryptKey()
    {
        return substr(str_pad(self::$user, 8, '0'), 0, 8);
    }
}

