<?php
namespace app\api\controller;

use app\api\model\Banner as BannerModel;
use app\lib\exception\BaseException;
use think\facade\Request;
use think\facade\Config;

class Banner  extends Base
{
    public function index()
    {
        //验证参数
        $this->checkparame("banner_index", true);

        $bannermodel = new BannerModel();

        $id = Request::param('id');



        $result = $bannermodel->alias('a')
            ->field(['i.id,i.img_url'])
            ->join(['wx_banner_item'=>'i'],"a.id=i.banner_id and a.id=$id")
            ->select()
            ->withAttr('img_url', function ($value, $data) {
                $img_prefix = Config::get('setting.img_prefix');
                return $img_prefix.$value;
            });


        //检查是否有异常或者是空数据
        if ($result->isEmpty()) {
            throw  new BaseException(['msg'=>'获取的banner不存在']);
        }

        return $result;

   }



}
