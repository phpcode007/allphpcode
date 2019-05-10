<?php
namespace app\api\controller;

//use app\api\model\Banner as BannerModel;
use app\api\service\UserToken;
use app\lib\exception\BaseException;
use think\facade\Request;
use think\facade\Config;


class Token  extends Base
{
    public function getToken()
    {
        //验证参数
        //这里暂时不验证code,因为微信的code有特殊字符，选择信任微信。
//        $this->checkparame('Token_code', true);


        $code = Request::param('token_code');

        $ut = new UserToken($code);
        $token = $ut->get();

        return json_encode(['token'=>$token]);
//        echo $token;

    }

    //通用获取toekn
    public static function getCurrentTokenVar($key)
    {
        //request可以拿到header,所以拿到token跨域
        $token = Request::instance()->header('token');

//        halt($token);
        $vars = cache($token);

        if (!$vars) {
            throw new BaseException(['msg'=>'token不存在']);
        } else {

            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }

            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取的Token不存在');
            }



        }
    }

    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }


    //验证token
    public function verifyToken($token)
    {

//        echo $token;
//        halt('dasfd');
        if (!$token) {
            throw new BaseException(['msg'=>'token不能为空']);
        }

        $exist = cache($token);

        if ($exist) {
            return 'true';
        } else {
            return 'false';
        }

    }
}
