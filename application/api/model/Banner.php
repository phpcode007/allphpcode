<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/28
 * Time: 11:18
 */


namespace app\api\model;



class Banner extends Base
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wx_banner';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    //id传进来的话，不能修改和入库
    protected $readonly = ['id'];


//    public function getNameAttr($value)
//    {
//        $value = "http://www.xjq.com".$value;
//        return $value;
//    }

}