<?php
/** 图片上传类
 * Created by PhpStorm.
 * User: @Faith
 * Date: 2016-09-28
 * Time: 16:58
 */
namespace BaseComponents\base;

use yii\imagine\Image;

class UploadFile
{
    const NO_IMG_TYPE = '图片类型不支持';

    const NO_IMG_SIZE = '图片大小不能超过1M';

    const NO_API_DATA = '请求接口无数据返回';

    const NO_PARAM_ERR = '参数错误';

    private $isSize = false;

    private $allowImageSize = 1048576;

    private $allowImageType = 'image/jpg,image/jpeg,image/png,image/gif';

    private $uploadDir = 'upload';

    public static function run($url, $params)
    {
        return (new self())->UploadPictures($url, $params);
    }

    private function UploadPictures($url, $params)
    {

        $img = !empty($params['img']) ? $params['img'] : [];

        if (is_object($img) && !empty($params['data'])) {

            if ($img->size > $this->allowImageSize) {
                $this->ajaxReturn(31001, self::NO_IMG_SIZE);
            }
            if (!strpos($this->allowImageType, $img->type)) {
                $this->ajaxReturn(31001, self::NO_IMG_TYPE);
            }

            $imgInfo = getimagesize($img->tempName);

            $this->checkImgSize($imgInfo, $params['data']);

            $result = $this->dealImg($img);

            $this->rmdirs($this->uploadDir);

            $response = Http::run($url, ['img' => $result], Http::POST);

            if ($response != false && $response['code'] === 0) {
                \Yii::info('[Upload File] request:' . $url . '; params: ' . json_encode($params) . ' response:' . json_encode($response));
                $this->ajaxReturn(0, $response['data']);
            } else {
                \Yii::warning('[Upload File] request:' . $url . '; params: ' . json_encode($params) . ' response:' . json_encode($response));
                $this->ajaxReturn(31001, self::NO_API_DATA);
            }

        } else {
            $this->ajaxReturn(31001, self::NO_PARAM_ERR);
        }
    }

    /**
     *检查图片的尺寸
     */
    private function checkImgSize($imgInfo, $params)
    {

        if ($imgInfo[0] == '225' && $imgInfo[1] == '140' && $params['name'] == 'image_thumbnail') {
            $this->isSize = true;
        } elseif ($imgInfo[0] == '100' && $imgInfo[1] == '100' || $imgInfo[0] == '84' && $imgInfo[1] == '84' && $params['name'] == 'icon_url') {
            $this->isSize = true;
        } elseif ($imgInfo[0] == '280' && $imgInfo[1] == '160') {
            $this->isSize = true;
        } elseif ($imgInfo[0] == '725' && $imgInfo[1] == '450' && $params['name'] == 'image_add[]') {
            $this->isSize = true;
        } elseif ($imgInfo[0] == '720' && $imgInfo[1] == '300' || $imgInfo[0] == '640' && $imgInfo[1] == '286' && $params['name'] == 'bannerAdd') {
            $this->isSize = true;
        } elseif ($imgInfo[0] == '420' && $imgInfo[1] == '270' && $params['name'] == 'appIcon') {
            $this->isSize = true;
        } elseif ($params['name'] == 'params[homeIcon]' || $params['name'] == 'params[awayIcon]') {
            $this->isSize = true;
        } elseif ($params['name'] == 'teamLogo' || $params['name'] == 'params[banner]' || $params['name'] == 'params[v_banner]' || $params['name'] == 'img[]') {
            $this->isSize = true;
        }
        if (!$this->isSize) {
            $this->ajaxReturn(31001, '您上传的尺寸为' . $imgInfo[0] . '*' . $imgInfo[1] . '不符合要求');
            exit;
        }
    }

    /**
     * 处理图片,返回二进制流
     */
    private function dealImg($img)
    {
        $fileName = $this->uploadDir . '/' . time() . rand(10000, 99999) . '.' . $img->extension;

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }

        if ($img->saveAs($fileName)) {

            $imgInfo = getimagesize($fileName);

            $width = isset($imgInfo[0]) ? $imgInfo[0] : 0;
            $height = isset($imgInfo[1]) ? $imgInfo[1] : 0;

            if ($width || $height) {

                $imagine = new Image();

                $imagine->thumbnail($fileName, $width, $height)->save($fileName);

                $fp = fopen($fileName, "r");
                $file = fread($fp, filesize($fileName));

                $file = base64_encode($file);

                return $file;
            }
        }
    }

    /** 返回Json结果
     * @param $code
     * @param string $data
     * @param string $message
     * @param bool $exit
     */
    private function ajaxReturn($code, $data = '', $message = '', $exit = true)
    {
        $json = json_encode([
            'code' => intval($code),
            'msg' => $message,
            'data' => $data
        ]);

        $callback = $_REQUEST['callback'];

        $domain = substr($_SERVER['SERVER_NAME'], strpos($_SERVER['SERVER_NAME'], '.') + 1);
        
        $script = '<script>document.domain = "' . $domain . '";parent.' . $callback . '(' . json_encode($json) . ');</script>';

        echo $script;
        $exit && exit();

    }

    /** 移除upload文件夹下所有图片
     * @param $dir
     * @return bool|null
     */
    private function rmdirs($dir)
    {
        if (!is_dir($dir)) {
            return null;
        }

        $fh = opendir($dir);
        while (($row = readdir($fh)) !== false) {
            if ($row == '.' || $row == '..') {
                continue;
            }
            if (!is_dir($dir . '/' . $row)) {
                //删除文件
                unlink($dir . '/' . $row);
            }
            self::rmdirs($dir . '/' . $row);

        }
        //删除目录
        //rmdir($dir);
        closedir($fh);
        return true;
    }
}
