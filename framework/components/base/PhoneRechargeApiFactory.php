<?php
namespace BaseComponents\base;

class PhoneRechargeApiFactory
{

    const API_TYPE_FEES = 1;
    const API_TYPE_TRAFFIC = 2;

    //来源
    const SOURCE_JUHE = 'Juhe';
    const SOURCE_HUYI = 'Huyi';

    /*
     * 切换时需要将admin下面的rules_bak里面的规则替换到rules去
     * 同时更改CURR_API
     */
    const CURR_API = 'Juhe';

    // const CURR_API = 'ApiX';

    /**
     *
     * @param string $name
     * @throws \Exception
     * @return IPhoneRechargeApi
     */
    static public function getApi($type)
    {
        switch ($type) {
            case self::API_TYPE_FEES:
                $class = "\\BaseComponents\\base\\" . self::CURR_API . 'FeesApi';
                break;
            case self::API_TYPE_TRAFFIC:
                $class = "\\BaseComponents\\base\\" . self::CURR_API . 'TrafficApi';
                break;
        }

        if (class_exists($class)) {
            return call_user_func("$class::getInstance");
        } else {
            throw new \Exception("Class $class not found!");
        }
    }


    static public function getApiNew($type, $source, IJuheApiConfig $config)
    {
        switch ($source) {
            case self::SOURCE_JUHE:
                $api = self::getJuheApi($type, $config);
                break;
            case self::SOURCE_HUYI:
                $api = self::getHuyiApi($type);
                break;
        }

        return $api;
    }


    //互亿API
    static public function getHuyiApi($type)
    {
        switch ($type) {
            case self::API_TYPE_FEES:
                $class = "\\BaseComponents\\base\\" . self::SOURCE_HUYI . 'FeesApi';
                break;
            case self::API_TYPE_TRAFFIC:
                $class = "\\BaseComponents\\base\\" . self::SOURCE_HUYI . 'TrafficApi';
                break;
        }
        if (class_exists($class)) {
            return call_user_func("$class::getInstance", []);
        } else {
            throw new \Exception("Class $class not found!");
        }
    }

    //聚合API
    static public function getJuheApi($type, IJuheApiConfig $config)
    {
        switch ($type) {
            case self::API_TYPE_FEES:
                $class = "\\BaseComponents\\base\\" . self::SOURCE_JUHE . 'FeesApiNew';
                break;
            case self::API_TYPE_TRAFFIC:
                $class = "\\BaseComponents\\base\\" . self::SOURCE_JUHE . 'TrafficApiNew';
                break;
        }
        if (class_exists($class)) {
            return call_user_func("$class::getInstance", $config);
        } else {
            throw new \Exception("Class $class not found!");
        }
    }
}