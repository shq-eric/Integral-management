<?php
/**
 * Created by PhpStorm.
 * User: Nekoing
 * Date: 2018/2/28
 * Time: 12:18
 */

namespace BaseComponents\extensions\alipay\buildermodel;

class AlipayTradePayExtendParamsBuilder
{
    private $sysServiceProviderId;

    private $needBuyerRealnamed;

    private $transMemo;

    private $hbFqNum;

    private $hbFqSellerPercent;

    private $buildParams = [];

    public function getBuildParams()
    {
        return $this->buildParams;
    }

    /**
     * @return mixed
     */
    public function getSysServiceProviderId()
    {
        return $this->sysServiceProviderId;
    }

    /**
     * @param mixed $sysServiceProviderId
     */
    public function setSysServiceProviderId($sysServiceProviderId)
    {
        $this->sysServiceProviderId = $sysServiceProviderId;
        $this->buildParams['sys_service_provider_id'] = $sysServiceProviderId;
    }

    /**
     * @return mixed
     */
    public function getNeedBuyerRealnamed()
    {
        return $this->needBuyerRealnamed;
    }

    /**
     * @param mixed $needBuyerRealnamed
     */
    public function setNeedBuyerRealnamed($needBuyerRealnamed)
    {
        $this->needBuyerRealnamed = $needBuyerRealnamed;
        $this->buildParams['needBuyerRealnamed'] = $needBuyerRealnamed;
    }

    /**
     * @return mixed
     */
    public function getTransMemo()
    {
        return $this->transMemo;
    }

    /**
     * @param mixed $transMemo
     */
    public function setTransMemo($transMemo)
    {
        $this->transMemo = $transMemo;
        $this->buildParams['TRANS_MEMO'] = $transMemo;
    }

    /**
     * @return mixed
     */
    public function getHbFqNum()
    {
        return $this->hbFqNum;
    }

    /**
     * @param mixed $hbFqNum
     * @throws \Exception
     */
    public function setHbFqNum($hbFqNum)
    {
        if (!in_array($hbFqNum, [3, 6, 12])) {
            throw new \Exception("花呗分期期数设置错误");
        }

        $this->hbFqNum = $hbFqNum;
        $this->buildParams['hb_fq_num'] = $hbFqNum;
    }

    /**
     * @return mixed
     */
    public function getHbFqSellerPercent()
    {
        return $this->hbFqSellerPercent;
    }

    /**
     * @param mixed $hbFqSellerPercent
     * @throws \Exception
     */
    public function setHbFqSellerPercent($hbFqSellerPercent)
    {
        if ($hbFqSellerPercent !== 0 && $hbFqSellerPercent !== 100) {
            throw new \Exception("花呗分期手续费设置错误");
        }

        $this->hbFqSellerPercent = $hbFqSellerPercent;
        $this->buildParams['hb_fq_seller_percent'] = $hbFqSellerPercent;
    }


}