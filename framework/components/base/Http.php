<?php
/**
 * Http业务类
 * @author coso
 * @since 2015-05-20
 */
namespace BaseComponents\base;

use Yii;
use yii\curl\Curl;
use yii\helpers\VarDumper;

class Http extends Curl
{

    const GET = 1;

    const POST = 2;

    const PUT = 3;

    const DELETE = 4;

    const HEAD = 5;

    private $param = '';

    private $isUrlcode = '';

    private $url = '';

    /**
     * 执行
     */
    public static function run($queryUrl, $param = [], $method = self::GET, $raw = false, $isUrlcode = true, $header = [])
    {
        return (new self())->_execute($queryUrl, $param, $method, $raw, $isUrlcode, $header);
    }

    private function _execute($queryUrl, $param, $method, $raw, $isUrlcode, $header)
    {
        $this->param = empty($param) ? array() : $param;
        $this->isUrlcode = $isUrlcode;
        $result = null;

        if ( !empty($header)) {
            $this->setOption(CURLOPT_HTTPHEADER, $header);
            $this->setOption(CURLOPT_HEADER, true);
        }
        else {
            $this->setOption(CURLOPT_HEADER, false);
        }

        switch ($method) {
            case self::GET:
                $result = $this->get($queryUrl, $raw);
                break;
            case self::POST:
                $result = $this->post($queryUrl, $raw);
                break;
            case self::PUT:
                $result = $this->put($queryUrl, $raw);
                break;
            case self::DELETE:
                $result = $this->delete($queryUrl, $raw);
                break;
            case self::HEAD:
                $result = $this->head($queryUrl);
                break;
            default:
                $result = $this->get($queryUrl, $raw);
                break;
        }
        return $this->handleErrLog($result);
    }

    public function get($url, $raw = true)
    {
        if (! empty($this->param)) {
            $url .= (strpos($url, '?') === false) ? '?' : '&';
            $url .= is_array($this->param) ? http_build_query($this->param) : $this->param;
        }

        $this->setOption(CURLOPT_SSL_VERIFYPEER, FALSE);
        $this->setOption(CURLOPT_SSL_VERIFYHOST, FALSE);
        $this->setOption(CURLOPT_SSLVERSION, 1);
        return parent::get($url, $raw);
    }

    public function post($url, $raw = true)
    {
        if (is_array($this->param)) {
            foreach ($this->param as $key => $val) {
                if ($this->isUrlcode) {
                    $encode_key = urlencode($key);
                } else {
                    $encode_key = $key;
                }
                if ($encode_key != $key) {
                    unset($query[$key]);
                }
                if ($this->isUrlcode) {
                    $query[$encode_key] = urlencode($val);
                } else {
                    $query[$encode_key] = $val;
                }
            }
        }
       
        $this->setOption(CURLOPT_POST, true);
        $this->setOption(CURLOPT_POSTFIELDS, $this->param);
        $this->setOption(CURLOPT_SSL_VERIFYPEER, FALSE);
        $this->setOption(CURLOPT_SSL_VERIFYHOST, FALSE);
        $this->setOption(CURLOPT_SSLVERSION, 1);
        return parent::post($url, $raw);
    }

    public function put($url, $raw = true)
    {
        return parent::put($url, $raw);
    }

    public function delete($url, $raw = true)
    {
        return parent::delete($url, $raw);
    }

    public function head($url)
    {
        return parent::head($url);
    }

    /**
     * 记录错误日志
     */
    private function handleErrLog($result)
    {
        if ($result == false) {
            $options = ! empty($this->getOptions()) ? VarDumper::dumpAsString($this->getOptions()) : '';
            $message = 'this requerst code :' . $this->responseCode . ', url : ' . $this->url . ', options :' . $options;
            Yii::error($message, 'curl');
        }
        return $result;
    }
}