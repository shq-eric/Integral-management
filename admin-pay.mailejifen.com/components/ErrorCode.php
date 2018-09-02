<?php
/**
 * 错误代码管理
 *
 * @author coso
 * demo : ErrorCode::ERR_SYTEM
 */
namespace app\components;

class ErrorCode
{

    /**
     * * 关于系统底层错误代码 **
     */
    const ERR_SYTEM = 100; // 系统错误
    const ERR_PARAM = 101; // 参数错误
    const ERR_EMPTY_RESULT = 102; // 请求接口无返回
    const ERR_EMAIL_FAILED = 103; // 系统邮件发送失败
    const ERR_NO_DATA = 201; // 数据不存在
    const ERR_INVALID_PARAMETER = 400; // 请求参数错误
    const ERR_CHECK_SIGN = 401; // 签名验证错误
    const ERR_NO_PARAMETERS = 402; // 参数缺失
    const ERR_NO_ACCESS = 403;  //无访问权限
    const ERR_404 = 404; // 页面未找到
    const ERR_VER_NOTEXISTS = 405; // 版本号错误
    const ERR_DB_ERROR = 406; // 数据库操作错误
    const ERR_UNKNOWN_TYPE = 407;
    const ERR_EMAIL_VERIFY_EXPIRED = 408; // 邮箱验证码过期
    const ERR_MOBILE_VERIFY_EXPIRED = 409; // 手机验证码过期
    const ERR_LOGIN_FAILED = 410; // 用户不存在或密码错误
    const ERR_FORGOT_EMAIL_NOT_EXISTS = 411; // 此邮箱尚未注册
    const ERR_USER_UNACTIVE = 412; // 此邮箱尚未注册
    const ERR_USER_NONE = 413; // 此用户不存在
    const ERR_OLD_PASSWORD = 414; // 原密码错误
    const ERR_INCONFORMITY_PASSWORD = 415; // 两次密码不一致
    const ERR_BEFORE_PASSWORD = 416; // 新密码不能与原密码相同
    const ERR_ORDER_STATUS_ERR = 510; //订单状态错误
    const SUCCESS = 1; // 操作成功
    const NORMAL_SUCCESS = 0; // 操作成功
    const ERR_FOREIGN_HTTP_CODE = 408;

    const ERR_API_RESULT_EXCEPTION = 420;   //API返回结果异常
    const ERR_API_STATUS_EXCEPTION = 421;   //API调用状态码异常
    const ERR_API_REQUEST_EXCEPTION = 422;  //API请求异常
    const ERR_TOKEN_NULL = 423;  //API请求异常
    
    const ERR_AFTER_SALES_ORDER_EXISTS = 700;

    //系统权限
    const NO_ACCESS = 1000;
    const ACCESS_CAN_NOT_BE_EMPTY = 1001;
    const CREATE_ACCESS_FAIL = 1002;
    const NO_EXISTS_PARENT_ACCESS = 1003;
    const ROLE_CAN_NOT_BE_EMPTY = 1004;
    const CREATE_ROLE_FAIL = 1005;
    const CREATE_USER_FAIL = 1006;
    const INVALID_USER = 1007;
    const DELETE_ACCESS_FAIL = 1008;

    const ERR_FILE_READ = 30001; //读取文件错误
    const ERR_FILE_SAVE = 30002; //保存文件错误
    const ERR_FILE_TYPE = 30003; //文件类型错误
    const ERR_FILE_SIZE = 30004; //文件大小错误

    private static $_messages = array(
        0 => 'success',
        100 => '系统错误',
        101 => '参数错误',
        102 => '请求接口无返回',
        103 => '系统邮件发送失败',
        201 => '数据不存在',
        402 => '参数缺失',
        403 => '无访问权限',
        404 => '页面未找到',
        407 => '未知类型的系统错误',
        408 => '链接已过期',
        409 => '验证码已过期',
        410 => '用户不存在或密码错误',
        411 => '此邮箱尚未注册',
        412 => '此账户尚未激活',
        413 => '此用户不存在',
        414 => '原密码错误',
        415 => '两次密码不一致',
        416 => '新密码不能与原密码相同',
       
        510 => '订单状态错误',
        
        700 => '该订单存在未完成的售后单',
        
        //系统权限
        1000 => '你没有权限这么做!',
        1001 => '权限不能为空',
        1002 => '添加权限失败',
        1003 => '不存在等父级权限',
        1004 => '名称不能为空',
        1005 => '创建用户组失败',
        1006 => '创建用户失败',
        1007 => '该账户已被禁用',
        1008 => '删除权限失败',

        //图片上传
        30001 => '未读取到文件',
        30002 => '保存文件失败',
        30003 => '文件类型错误',
        30004 => '文件大小错误',

        90000 => '验证码错误',
        90001 => '应用名称已存在',
        90002 => '无效的请求',
        90003 => '还有子应用无法删除',

        //goods线
        91000 => '已经存在的title或者名称',
        91001 => '添加标签失败',
        91002 => '标签最多添加5个',
        91003 => '该标签还有未删除的原型商品',
        91004 => '删除标签失败',
        91005 => '聚合卡券库存不能大于10',
        91006 => '请选择聚合卡券类型',
    );

    /**
     * 产生错误信息 返回类型数组
     * @param unknown $errorCode
     * @param string $msg
     * @param unknown $data
     * @return array
     */
    public static function errorMsg($errorCode, $msg = '', $data = array())
    {
        $response ['code'] = $errorCode;

        if ($msg != '') {
            $response ['error'] = $msg;
            $response ['msg'] = $msg;
        } else {
            $response ['error'] = self::getErrorMsg($errorCode);
            $response ['msg'] = self::getErrorMsg($errorCode);
        }

        $response ['data'] = $data;
        return $response;
    }

    /**
     * 产生错误信息 返回类型对象
     * @param unknown $errorCode
     * @param string $msg
     * @param unknown $data
     * @return StdClass
     */
    public static function errorMsgObj($errorCode, $msg = '', $data = '')
    {
        $response = CoreHelper::initResult();
        $response->code = $errorCode;

        if ($msg != '') {
            $response->msg = $msg;
        } else {
            $response->msg = self::getErrorMsg($errorCode);
        }

        if (!empty($data)) {
            $response->data = $data;
        }

        return $response;
    }

    /**
     * 根据错误代码返回错误信息
     * @param $errorCode
     * @return string
     */
    public static function getErrorMsg($errorCode)
    {
        return (isset (self::$_messages [$errorCode])) ? self::$_messages [$errorCode] : '';
    }
}

?>