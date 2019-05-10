<?php
namespace app\api\controller;



use app\lib\exception\BaseException;

use think\facade\Request;

class Order  extends Base
{


    public function placeOrder()
    {

        $params = Request::param();

        $params = htmlspecialchars_decode($params[0]);

        $params = json_decode($params, true);

        //验证商品参数
//        $this->checkparame("Order_placeOrder");
        //不使用框架自动验证框架，自己写一个验证。
        $result = $this->checkProductsArray($params);

        if (!$result) {
            return '商品参数有问题';
        }

//        echo '商品参数通在ddddddddddddddd过';
//        print_r($params);
//        echo '????????';
        echo $uid = Token::getCurrentUid();


    }

    //验证商品数组参数
    private function checkProductsArray($params)
    {
        if (!is_array($params)) {
            throw new BaseException(['msg'=>'111111111商品参数不正确']);
        }

        if (empty($params)) {
            throw new BaseException(['msg'=>'商品列表不能为空2222222222']);
        }

        foreach ($params as $value) {

            foreach ($value as $v) {
                $result = zhengzhengshu($v);

                if (!$result) {
                    return false;
                }
            }
        }

        return true;
    }

}
