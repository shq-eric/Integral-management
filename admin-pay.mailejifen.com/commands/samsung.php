<?php

class Http
{
    private static $url = 'http://tongji.test.mailejifen.com/site/index'; //推送至统计域
    private static $goodsAccessUrl = 'http://tongji.test.mailejifen.com/site/goods-access-statis'; //推送至统计域
    private static $shUrl = '/sh/samsung.sh'; // 统计pv,uv shell脚本
    private static $goodsShUrl = '/sh/goods_details.sh'; // 统计商品pv,uv脚本
    private static $oriUrl = ''; // referer url
    private static $data = []; // 发出的数据 post,put
    private static $method; // 访问方式，默认GET

    public static function send($url, $data = [], $method = 'get')
    {
        if (!$url) exit('url can not be null');
        self::$url = $url;
        self::$method = $method;
        $urlArr = parse_url($url);
        self::$oriUrl = $urlArr['scheme'] . '://' . $urlArr['host'];
        self::$data = $data;
        if (!in_array(
            self::$method,
            array('get', 'post', 'put', 'delete')
        )
        ) {
            exit('error request method type!');
        }

        $func = self::$method . 'Request';
        return self::$func(self::$url);
    }

    /**
     * 基础发起curl请求函数
     * @param int $is_post 是否是post请求
     */
    private static function doRequest($is_post = 0)
    {
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, self::$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        // 来源一定要设置成来自本站
        curl_setopt($ch, CURLOPT_REFERER, self::$oriUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        if ($is_post == 1) curl_setopt($ch, CURLOPT_POST, $is_post);//post提交方式
        if (!empty(self::$data)) {
            self::$data = self::dealPostData(self::$data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, self::$data);
        }

        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }

    /**
     * 发起get请求
     */
    public static function getRequest()
    {
        return self::doRequest(0);
    }

    /**
     * 发起post请求
     */
    public static function postRequest()
    {
        return self::doRequest(1);
    }

    /**
     * 处理发起非get请求的传输数据
     *
     * @param array $postData
     */
    public static function dealPostData($postData)
    {

        //if (!is_array($postData)) exit('post data should be array');

        $param = is_array($postData) ? http_build_query($postData) : $postData;
//        $o = '';
//        foreach ($postData as $k => $v) {
//            $o .= "$k=" . urlencode($v) . "&";
//        }
//        $postData = substr($o, 0, -1);
        return $param;
    }

    /**
     * 发起put请求
     */
    public function putRequest($param)
    {
        return self::doRequest(2);
    }

    /**
     * 发起delete请求
     */
    public function deleteRequest($param)
    {
        return self::doRequest(3);
    }

    /**
     * 收集pv , uv
     */
    public static function doTask()
    {
        $data['pv'] = 0;
        $data['uv'] = 0;

        if (file_exists(self::$shUrl)) {
            exec(self::$shUrl, $result);
        } else {
            die('File Does Not Exist!');
        }
        if ($result) {
            foreach ($result as $k => $v) {
                $v = explode(' ', $v);
                if (isset($v[0])) {
                    $data['pv'] += $v[0];
                }

            }
        }
        $data['uv'] = count($result);

        self::send(self::$url, $data);

    }

    /**
     * 收集商品pv,uv
     */
    public static function statisGoods()
    {
        if (file_exists(self::$goodsShUrl)) {
            exec(self::$goodsShUrl . ' pv', $resPv);
            exec(self::$goodsShUrl . ' uv', $resUv);
            $pv = [];
            $uv = [];
            $ids = [];
            if ($resPv && $resUv) {
                foreach ($resPv as $key => $value) {
                    $value = explode(' ', $value);
                    $goodsId = substr($value[1], strpos($value[1], "=") + 1);
                    if (preg_match("/^\d*$/", $goodsId)) {
                        $pv[$goodsId] = $value[0];
                    }
                }

                foreach ($resUv as $key => $value) {
                    $value = explode(' ', $value);
                    $id = substr($value[1], strpos($value[1], "=") + 1);
                    if (preg_match("/^\d*$/", $id)) {
                        $ids[] = $id;
                    }
                }
                if ($ids) {
                    $uv = array_count_values($ids);
                }

                self::send(self::$goodsAccessUrl, ['pv' => $pv, 'uv' => $uv]);

            } else {
                die('Data Does Not Exist!');
            }

        } else {
            die('File Does Not Exist!');
        }
    }

}

Http::doTask();
Http::statisGoods();


