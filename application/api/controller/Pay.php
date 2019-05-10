<?php
namespace app\api\controller;

//require_once '/extend/wxpay/WxPay.Api.php';

// 加载基础文件
//require __DIR__ . '\../../extend/wxpay/WxPay.Api.php';


require '../extend/wxpay/WxPay.Api.php';
require '../extend/wxpay/WxPay.Config.php';

class Pay  extends Base
{
    public function index()
    {
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no(1324);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee(10);
        $wxOrderData->setBody('零售商贩');
        $wxOrderData->SetOpenid('o-I8J4_DjHHPq69mGNuH-MHuuPJQ');
        $wxOrderData->SetNotify_url('http://qq.com');

        $this->getPaySignature($wxOrderData);
   }

    private function getPaySignature($wxOrderData)
    {
        $config = new \WxPayConfig();
//        new \WxPayConfig();
        $wxOrder = \WxPayApi::unifiedOrder($config,$wxOrderData);

        halt($wxOrder);
    }

}
