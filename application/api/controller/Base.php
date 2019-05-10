<?php
namespace app\api\controller;

use app\lib\exception\BaseException;
use think\Controller;
use app\lib\validate\JDShopValidate;
use think\facade\Config;

class Base  extends Controller
{
    //如果你的控制器类继承了系统控制器基类（\think\Controller）的话，
    //可以定义控制器初始化方法initialize，该方法会在调用控制器的方法之前首先执行
    //如非必要，不建议直接修改控制器的架构函数。

    protected function checkparame($scene)
    {


        //验证参数是否正确
        $checkparamresult = (new JDShopValidate())->goCheck($scene,true);

        if ($checkparamresult !== true) {
            throw new BaseException(['msg'=>$checkparamresult]);
        }

    }


    public function imgurl($result)
    {
        $img_prefix = Config::get('setting.img_prefix');

        foreach ($result as $key => $value) {
            $value['img_url'] = $img_prefix.$value['img_url'];
        }

        return $result;
    }
}
