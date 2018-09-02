<?php
/**
 * Created by PhpStorm.
 * User: neo.xu
 * Date: 2015/12/11
 * Time: 11:09
 */
namespace app\components;

use Yii;
use app\components\ErrorCode;

/**
 * 验证器
 * Class ValidateHelper
 * @package app\components
 */
class ValidateHelper {


    /**
     * 判断是否是正整数
     * @param $num
     * @param string $alias
     * @return bool
     * @throws \Exception
     */
    public static function isPositiveInt($num ,$alias = '') {
        if($num > 0 && floor($num) == $num) {
            return true;
        }
        else {
            throw new \Exception($alias.ErrorCode::getErrorMsg(ErrorCode::VALIDATE_POSITIVE_INT),ErrorCode::VALIDATE_POSITIVE_INT);
        }
    }

    /**
     * 判断是否是自然熟
     * @param $num
     * @return bool
     * @throws \Exception
     */
    public static function isNaturalNumber($num ,$alias = '') {
        if($num >= 0 && floor($num) == $num) {
            return true;
        }
        else {
            throw new \Exception($alias.ErrorCode::getErrorMsg(ErrorCode::VALIDATE_NATURAL_NUMBER),ErrorCode::VALIDATE_NATURAL_NUMBER);
        }
    }


    /**
     * 验证0|1
     * @param $num
     * @param string $alias
     * @return bool
     * @throws \Exception
     */
    public static function isOneOrZero($num ,$alias = '') {
        if($num == 0 || $num == 1 ) {
            return true;
        }
        else {
            throw new \Exception($alias .ErrorCode::getErrorMsg(ErrorCode::VALIDATE_ONE_OR_ZERO),ErrorCode::VALIDATE_ONE_OR_ZERO);
        }
    }

}