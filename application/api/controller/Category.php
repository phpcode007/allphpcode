<?php
namespace app\api\controller;

use app\api\model\Category as CategoryModel;
use app\lib\exception\BaseException;
use think\facade\Request;
use think\facade\Config;


class Category  extends Base
{
    public function getAllCategories()
    {
        //验证参数
//
//        $this->checkparame("Product_new", true);

//        $id = Request::param('id');

        $category_model = new CategoryModel();



        $result = $category_model->select()
                    ->withAttr('topic_img_url', function ($value, $data) {
                        $img_prefix = Config::get('setting.img_prefix');
                        return $img_prefix.$value;
                    });

        //检查是否有异常
        if ($result->isEmpty()) {
            throw  new BaseException(['msg'=>'获取的分类不存在,请检查参数']);
        }

        return $result;
   }



    public function changeCategories()
    {
        //验证参数
//
//        $this->checkparame("Product_new", true);

        $id = Request::param('id');

        $category_model = new CategoryModel();



        $result = $category_model->where('id','=',$id)->select()
            ->withAttr('topic_img_url', function ($value, $data) {
                $img_prefix = Config::get('setting.img_prefix');
                return $img_prefix.$value;
            });

        //检查是否有异常
        if ($result->isEmpty()) {
            throw  new BaseException(['msg'=>'获取的分类不存在,请检查参数']);
        }

        return $result;
    }


















    public function getProductDetail()
    {
        //验证参数
        $this->checkparame("Product_getProductDetail", true);

        $productmodel = new ProductModel();




        $product_id = Request::param('product_id');

        //SELECT * from wx_product wp join wx_product_image  wpi on wp.id =  wpi.product_id;
//        $result = $productmodel->alias('')->select();

        $result = $productmodel->alias('wp')
//            ->field('img_url')
            ->join(['wx_product_image'=>'wpi'],"wp.id =  wpi.product_id and wp.id=$product_id")
            ->select();

        //检查是否有异常
        if (!$result) {
            throw  new BaseException(['msg'=>'获取的商品不存在,请检查参数']);
        }

        return $this->imgurl($result);
    }










    //处理图片url
//    public function imgurl($result)
//    {
//        $img_prefix = Config::get('setting.img_prefix');
//
//        foreach ($result as $key => $value) {
//            $value['topic_img_url'] = $img_prefix.$value['topic_img_url'];
//        }
//
//        return $result;
//    }

}
