<?php

namespace app\lib\exception;

use think\exception\Handle;
use think\facade\Log;
use think\facade\Request;

class ExceptionHandler extends  Handle
{
    private $code;
    private $msg;
    private $errorCode;

    //这里使用根Exception,防止传过来的参数转换不了
    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) {

            // baseException是基类，如果是这属于这个基类的，是自定义异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;

        } else {

            //因为对于php服务器开发者不友好，所以还设置一个开关，如果是服务器开发者，返回thinkphp默认的错误页面，比较清楚
            //如果不是php服务器开发者，返回json给客户端，对客户端友好。


            //抽取app_debug进入配置文件，所以选取了默认的参数
            if (config('app_debug')) {
                return parent::render($e);
            } else {

                //生产环境有异常，可以写入文件
                //这个是全局处理异常， 因为在写程序时有一些异常不可能方方面面都想到的
                //在这里就可以捕获到
                $this->code = 500;
                $this->msg = "服务器内部错误";
                $this->errorCode = 999;

                //在这里写入日志，先关闭全局的日志记录
                Log::write($e->getMessage(),'error');
            }



        }

        $request = Request::instance();


        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url(),
        ];

        return json($result, $this->code);

    }

}