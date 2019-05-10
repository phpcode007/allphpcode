<?php
namespace app\api\controller;

use app\api\model\Product as ProductModel;
use app\lib\exception\BaseException;
use think\facade\Request;
use think\facade\Config;
use app\api\model\Category as CategoryModel;


class Product  extends Base
{
    public function index()
    {
        //验证参数
        $this->checkparame("Product_new", true);

        $productmodel = new ProductModel();




        $product_count = Request::param('product_count');

        $result = $productmodel->order('create_time desc')->limit($product_count)->select();

        //检查是否有异常
        if (!$result) {
            throw  new BaseException(['msg'=>'获取的商品不存在,请检查参数']);
        }

        return $this->imgurl($result);
   }


    public function getProductDetail()
    {
        //验证参数
        $this->checkparame("Product_getProductDetail", true);

        $product_model = new ProductModel();




        $product_id = Request::param('product_id');

        //SELECT * from wx_product wp join wx_product_image  wpi on wp.id =  wpi.product_id;

//        $result = $productmodel->alias('wp')
////            ->field('img_url')
//            ->join(['wx_product_image'=>'wpi'],"wp.id =  wpi.product_id and wp.id=$product_id")
//            ->select();

        $result = $product_model->where('id', '=', $product_id)->find();

        //检查是否有异常
        if (!$result) {
            throw  new BaseException(['msg'=>'获取的商品不存在,请检查参数']);
        }

        $img_prefix = Config::get('setting.img_prefix');

        $result['imgs'] = $this->productimageurl($result['imgs']);
        $result['main_img_url'] = $img_prefix.$result['main_img_url'];

        return $result;
    }


    public function getAllInCategory()
    {
        //验证参数
        $this->checkparame("Product_getAllInCategory", true);

        $id = Request::param('id');

        $category_model = new CategoryModel();
        $cateinfo = $category_model->where('id', '=', $id)->select()
            ->withAttr('topic_img_url', function ($value, $data) {
                $img_prefix = Config::get('setting.img_prefix');
                return $img_prefix.$value;
            })
            ->toArray();

//        halt($cateinfo);


        $product_model = new ProductModel();

        $result = $product_model->where("category_id", "=", $id)->select()
            ->withAttr('main_img_url', function ($value, $data) {
                $img_prefix = Config::get('setting.img_prefix');
                return $img_prefix.$value;
            })
            ->toArray();

        if (!$result) {
            throw new BaseException(['msg'=>'分类的商品不存在']);
        }

//        $cateandresult = array_push($cateinfo, ['products'=>$result]);
//        $cateandresult = array_push($cateinfo, $result);

        $cateinfo['products'] = $result;


        return json_encode($cateinfo);

    }


    public function testjson()
    {
        $product_model = ProductModel::get(11);
        $product_model->summary = '我的总结dsfa';

        $tempjson = $product_model->property;


        //通过中转数组来更新某一个json字段，这样不会删除原来的json
//        $tempjson['保质期'] = "10000天";
//        $tempjson['品名只有我'] = '单独更3453453新成功';
        $tempjson['info'] = [1,2,3,4,5];

        $product_model->property = $tempjson;

        $product_model->save();


    }


    //处理单一图片
    public function imgurl($result)
    {
        $img_prefix = Config::get('setting.img_prefix');

        foreach ($result as $key => $value) {
            $value['main_img_url'] = $img_prefix.$value['main_img_url'];
        }

        return $result;
    }



    //处理一个商品所有图片url,包括json图片
    public function productimageurl($result)
    {
        $img_prefix = Config::get('setting.img_prefix');

        $jsondata = json_decode($result);

        foreach ($jsondata as $key => &$value) {

            $value = $img_prefix.$value;

        }

        return $jsondata;
    }

}
