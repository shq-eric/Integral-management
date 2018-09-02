<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/2/22
 * Time: 下午5:14
 */
namespace BaseComponents\helper;

use Yii;

class PageHelper
{
    public static $page = 0;
    public static $number = 0;
    public static $pages = 0;
    public static $pageSize = 10;
    public static $request = [];
    public static $prev = '';
    public static $next = '';
    public static $first = '';
    public static $last = '';


    public static function html($page, $pageSize, $number, $request = []) {
        $paself::count($pageSize, $number);

    }

    private static function count($pageSize, $number) {
        if($pageSize >= 0 && $number >= 0) {
            self::$pages = ceil($number/$pageSize);
        }
        else {
            throw new \Exception();
        }
    }

    /**
     * URL参数处理
     */
    private static function _getRequest($request)
    {
        $str = '';
        if(is_array($request)) {
            foreach ($request as $key => $val) {
                if(strtolower($key) != 'page'){
                    $str .= "&" . $key . "=" . $val;
                }
            }
            return $str;
        }
        else {
            return $request;
        }
    }
}