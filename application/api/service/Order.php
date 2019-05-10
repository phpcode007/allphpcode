<?php
namespace app\api\service;

use app\api\model\Product as ProductModel;
use app\lib\exception\BaseException;
use function PHPSTORM_META\elementType;

use app\api\model\Order as OrderModel;


class Order
{
    //客户端传过来给服务器的参数
    protected $oProducts;
    //从数据库查出来的真实商品
    protected $products;

    protected $uid;

    //下单
    public function place($uid,$oProducts)
    {
        $this->oProducts = $oProducts;
        $this->products = $this->getProductByOrder($oProducts);
        $this->uid = $uid;

        $status = $this->getOrderStatus();

        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }

        //开始创建订单
        $orderSnap = $this->snapOrder();

    }

    //创建订单
    private function createOrder()
    {
        $orderNumber = self::makeOrderNo();

        $order_model = new OrderModel();

        $order_model->user_id = $this->uid;
        $order_model->order_no = $orderNumber;
        $order_model->total_price = 1;
        $order_model->total_count = 2;
//        $order_model->snap_img = $snap['snapImg']
//        $order_model->snap_name = $snap['snapName'];
//        $order_model->snap_address = $snap['snapAddress'];
//        $order_model->snap_items = json_encode($snap['pStatus']);
        $order_model->save();

    }

    //生成订单号
    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2019] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }










    //订单快照改写
//    private function snapOrder($status)
//    {
//        $snap = [
//            'orderPrice' => 0,
//            'totalCount' => 0,
//            'pStatus' => [],
//            'snapAddress' => null,
//            'snapName'=> '',
//            'snapImg' => '',
//        ];
//
//        $snap['orderPrice'] = $status['orderPrice'];
//        $snap['totalCount'] = $status['totalCount'];
//    }

    //根据用户传过来的参数，查询查实的商品信息
    public function getProductByOrder($oProducts)
    {
        $oPIDs = [];

        //先把所有商品ID号拿出来，然后再查询
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }

        $productmodel = new ProductModel();

        $products = $productmodel->visible(['id','price','stock','name','main_img_url'])->all($oPIDs)->toArray();

        return $products;
    }


    //对库存量进行检测
    private function getOrderStatus()
    {
        $status = [
            //是否通过
            'pass' => true,
            //订单总价
            'orderPrice' => 0,
            //总数量
            'totalCount' => 0,
            //历史订单使用的状态数组
            'pStatusArray' => []
        ];

        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus(
                $oProduct['product_id'],$oProduct['count'],$this->products
            );

            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }

            $status['orderPrice'] += $pStatus['totalPrice'];

            //把数组的订单状态push
            array_push($status['pStatusArray'], $pStatus);


        }


        return $status;
    }

//    //根据客户端传过来的参数来查看是否有库存
//    private function getProductStatus($oPid,$count,$products)
//    {
//        $pIndex = -1;
//
//        $pStatus = [
//            'id' => null,
//            'haveStock' => false,
//            'count' => 0,
//            'name' => '',
//            'totalPrice' => 0
//        ];
//
//        for ($i = 0; $i < count($products); $i++) {
//            if ($oPid == $products[$i]['id']) {
//                $pIndex = $i;
//            }
//
//            if ($pIndex == -1) {
//                throw new BaseException(['msg' => '商品不存在,创建订单失败']);
//            }
//        }
//
//
//
//
//    }













    //商品数组太多，所以要有一个找到对应商品数量的方法
    private function getProductStatus($oPID,$oCount,$products)
    {
        $pIndex = -1;

        $pStatus = [
            'id'=> null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];

        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[i]['id']) {
                $pIndex = $i;
            }
        }

        if ($pIndex == -1) {
            //客户端传过来的id可能不存在
            throw new BaseException(['msg'=>'id为'.$oPID.'的商品不存在,创建订单失败']);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $product['price'] * $oCount;

            if ($product['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }


        return $pStatus;


    }
}
