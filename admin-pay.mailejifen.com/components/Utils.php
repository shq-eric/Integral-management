<?php
namespace app\components;

class Utils
{

    /**
     * 获得随机字符串
     * @param unknown $length
     * @param string $chars
     * @return string
     */
    public static function genRandStr($length, $chars = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM')
    {
        $randStr = '';
        while ($length--) {
            $randStr .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $randStr;
    }


    /**删除指定文件夹下所有文件
     * @param $dir
     * @return bool|null
     */
    public static function rmDirsFile($dir)
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
            self::rmDirsFile($dir . '/' . $row);

        }
        closedir($fh);
        return true;
    }

    /**
     * 获得当前http协议（http/https）
     */
    public static function getHttpScheme()
    {
        if (isset($_SERVER['HTTPS'])) {
            return $_SERVER['HTTPS'] === 1 || $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        } elseif (isset($_SERVER['SERVER_PORT'])) {
            return $_SERVER['SERVER_PORT'] == '443' ? 'https' : 'http';
        }
    }

    public static function underline2hump($valName)
    {
        $result = '';
        $parts = preg_split('/_/', $valName);
        foreach ($parts as $p) {
            $result .= ucfirst($p);
        }
        return $result;
    }

    /**
     * 批量执行
     * @param unknown $arrs
     * @param unknown $execFunc
     * @param number $batchLen
     */
    public static function batchExec($arrs, $execFunc, $batchLen = 100)
    {
        $success = 0;
        while (count($arrs) > 0) {
            $replaceLen = count($arrs) > $batchLen ? $batchLen : count($arrs);
            $batch = array_splice($arrs, 0, $replaceLen);

            $success += call_user_func($execFunc, $batch);
        }

        return $success;
    }

    /**
     * 类似range，生成时间数组
     * @param unknown $type day|month|year
     * @param unknown $sTime
     * @param unknown $eTime
     * @param string $format
     * @return multitype:string unknown
     */
    static public function generateTimeNodes($type, $sTime, $eTime)
    {
        $result = [];
        switch ($type) {
            case 'day':
                $sTime = date('Y-m-d', strtotime($sTime));
                $eTime = date('Y-m-d', strtotime($eTime));
                while ($sTime <= $eTime) {
                    $result[] = $sTime;
                    $sTime = date('Y-m-d', strtotime($sTime . ' +1 day'));
                }
                break;
            case 'month':
                $sTime = date('Y-m', strtotime($sTime));
                $eTime = date('Y-m', strtotime($eTime));
                while ($sTime <= $eTime) {
                    $result[] = $sTime;
                    $sTime = date('Y-m', strtotime($sTime . '-01 +1 month'));
                }
                break;
            case 'year':
                $sTime = substr($sTime, 4);
                while ($sTime <= $eTime) {
                    $result[] = strval($sTime++);
                }
                break;
        }

        return $result;
    }
}

?>