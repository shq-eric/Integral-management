<?php
namespace BaseComponents\base;

class AlipayApi extends PayApi
{

    private static $instance;

    /**
     * 获得实例
     * 
     * @return \BaseComponents\base\PayApi
     */
    static public function getInstance($config)
    {
        if (! self::$instance) {
            self::$instance = new static($config);
        }
        
        return self::$instance;
    }

    public function callRecharge($orderSn, $amount, $subject, $description = '')
    {
        $parameter = array(
            "service" => $this->config['service'],
            "partner" => $this->config['partner'],
            "seller_id" => $this->config['seller_id'],
            "payment_type" => $this->config['payment_type'],
            "notify_url" => $this->config['notify_url'],
            "return_url" => $this->config['return_url'],
            
            "anti_phishing_key" => $this->config['anti_phishing_key'],
            "exter_invoke_ip" => $this->config['exter_invoke_ip'],
            "out_trade_no" => $orderSn,
            "subject" => $subject,
            "total_fee" => sprintf("%.2f", $amount / 100),
            "body" => $description,
            "_input_charset" => trim(strtolower($this->config['input_charset']))
        );
        
        $this->filterParams($parameter);
        $this->signData($parameter);
        
        $url = $this->config['api'] . "?_input_charset=" . strtolower($this->config['input_charset']) . '&' . http_build_query($parameter);
        ksort($parameter);
        header('Location: ' . $url);
        exit();
    }

    public function checkSign($data)
    {
        $sign = $data['sign'];
        return $sign === $this->sign($data);
    }

    public function sign($data)
    {
        ksort($data);
        reset($data);
        
        unset($data['sign']);
        unset($data['sign_type']);
        
        $signStr = $this->linkParams($data);
        return md5($signStr . $this->config['key']);
    }

    private function signData(&$data)
    {
        $data['sign'] = $this->sign($data);
        $data['sign_type'] = strtoupper(trim($this->config['sign_type']));
    }

    private function filterParams(&$data)
    {
        foreach ($data as $k => &$v) {
            if (! $v && $v !== 0) {
                unset($data[$k]);
            }
        }
        return $data;
    }

    private function linkParams($data)
    {
        $str = '';
        foreach ($data as $k => $v) {
            $str .= "$k=$v&";
        }
        $str = substr($str, 0, strlen($str) - 1);
        return $str;
    }

    public function notifyValid($data)
    {
        $url = $this->config['api'] . '?service=notify_verify&partner=' . $this->config['partner'] . '&notify_id=' . $data['notify_id'];
        $result = file_get_contents($url);
        if ($result) {
            return true;
        } else {
            $this->error = $result;
            return false;
        }
    }
}

