<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/28
 * Time: 11:18
 */


namespace app\api\model;



class Category extends Base
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wx_category';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    //id传进来的话，不能修改和入库
    protected $readonly = ['id'];


}