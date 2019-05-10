<?php
namespace app\api\model;



class BannerItem extends Base
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wx_banner_item';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    //id传进来的话，不能修改和入库
    protected $readonly = ['id'];


    public function getTypeAttr($value)
    {
        $value = "http://www.xjq.com".$value;
        return $value;
    }

}