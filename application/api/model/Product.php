<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/28
 * Time: 11:18
 */


namespace app\api\model;



class Product extends Base
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wx_product';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    //id传进来的话，不能修改和入库
    protected $readonly = ['id'];

    // 设置json类型字段
    protected $json = ['property'];

    // 设置JSON数据返回数组
    protected $jsonAssoc = true;

}