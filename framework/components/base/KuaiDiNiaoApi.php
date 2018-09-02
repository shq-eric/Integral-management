<?php
namespace BaseComponents\base;

class KuaiDiNiaoApi
{
    const QUERY_URL = 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';

    const EXPRESS_CODE_EMS = 'EMS';

    const EXPRESS_CODE_FAST = 'FAST';

    const EXPRESS_CODE_GTO = 'GTO';

    const EXPRESS_CODE_HHTT = 'HHTT';

    const EXPRESS_CODE_SF = 'SF';

    const EXPRESS_CODE_STO = 'STO';

    const EXPRESS_CODE_YD = 'YD';

    const EXPRESS_CODE_YTO = 'YTO';

    const EXPRESS_CODE_ZTO = 'ZTO';

    const EXPRESS_CODE_ZJS = 'ZJS';

    public static function getExpresses()
    {
        return [
            'SF' => '顺丰',
            'YTO' => '圆通',
            'ZTO' => '中通',
            'STO' => '申通',
            'YD' => '韵达',
            'EMS' => 'EMS',
            'FAST' => '快捷',
            'GTO' => '国通',
            'HHTT' => '天天',
            'ZJS' => '宅急送',
            'ANE' => '安能',
            'HTKY' => '百世',
            'QFKD' => '全峰',
            'UC' => '优速',
            'ZTKY' => '中铁',
            'JD' => '京东',
            'DBL' => '德邦',
            'YZPY' => '邮政包裹',
            '' => '其他'
        ];
    }

    public static function query($barcode, $express = self::EXPRESS_CODE_ZJS)
    {
        if (empty(self::getExpresses()[$express])) {
            $express = '';
        }

        $requestData = json_encode([
            'OrderCode' => '',
            'ShipperCode' => "$express",
            'LogisticCode' => "$barcode"
        ]);

        $datas = array(
            'EBusinessID' => \Yii::$app->params['kuaidiniao']['businessID'],
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData),
            'DataType' => '2',
        );
        $datas['DataSign'] = self::encrypt($requestData, \Yii::$app->params['kuaidiniao']['appKey']);
        $result = Http::run(self::QUERY_URL, $datas, Http::POST);
        $result['ShipperCode'] = self::getExpresses()[$express];

        return $result;
    }

    /**
     * 电商Sign签名生成
     * @param data 内容
     * @param appkey Appkey
     * @return DataSign签名
     */
    public static function encrypt($data, $appkey)
    {
        return urlencode(base64_encode(md5($data . $appkey)));
    }
}

?>