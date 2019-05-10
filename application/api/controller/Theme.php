<?php
namespace app\api\controller;

use app\api\model\Theme as ThemeModel;
use app\lib\exception\BaseException;
use think\facade\Request;
use think\facade\Config;


class Theme  extends Base
{
    public function getThemeWithProducts()
    {
        //验证参数
        $this->checkparame("Theme_index", true);

        $theme_model = new ThemeModel();

        $id = Request::param('id');



        //SELECT * FROM wx_theme t JOIN wx_theme_product tp on t.id = tp.theme_id JOIN wx_product wp on tp.product_id = wp.id WHERE t.id=1;
        $result = $theme_model->alias('t')
                    ->field('wp.*,t.topic_img_url,t.head_img_url')
                    ->join(['wx_theme_product'=>'tp'],"t.id = tp.theme_id")
                    ->join(['wx_product'=>'wp'],"tp.product_id = wp.id")
                    ->where("t.id","=",$id)->select();

        //检查是否有异常
        if ($result->isEmpty()) {
            throw  new BaseException(['msg'=>'获取的主题商品不存在']);
        }

        $img_prefix = Config::get('setting.img_prefix');

        foreach ($result as $key => $value) {
            $value['topic_img_url'] = $img_prefix.$value['topic_img_url'];
            $value['head_img_url'] = $img_prefix.$value['head_img_url'];
        }




        return $result;

    }

    //获取首页主题
    public function getSimpleList()
    {
        //验证参数
        $this->checkparame("Theme_getSimpleList", true);

        $theme_model = new ThemeModel();

        $ids = Request::param('ids');

        $result = $theme_model->field(['id','topic_img_url'])
                    ->where('id','in',$ids)
                    ->select()
                    ->withAttr('topic_img_url', function ($value, $data) {
                        $img_prefix = Config::get('setting.img_prefix');
                        return $img_prefix.$value;
                    });

        if ($result->isEmpty()) {
            throw new BaseException(['msg'=>'获取的主题内容为空']);
        }

        return $result;

    }

}
