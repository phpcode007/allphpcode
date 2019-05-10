<?php
namespace app\api\service;

use app\api\model\User;
use app\lib\exception\BaseException;
use think\Exception;
use think\facade\Config;

use app\api\model\User as UserModel;


class UserToken
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {

        $this->code = $code;
        $this->wxAppID = Config::get('wx.app_id');
        $this->wxAppSecret = Config::get('wx.app_secret');
        $this->wxLoginUrl = sprintf(Config::get('wx.login_url'),$this->wxAppID,$this->wxAppSecret,$this->code);

    }

    public function get()
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult =  json_decode($result, true);

//        halt($wxResult);

        //经验的写法，这样判断微信返回失败比较好,用empty,
        if (empty($wxResult)) {
            //这个只是返回普通异常，不是用户自定义异常，不返回给用户，只是给服务器看
            throw new Exception("获取session_key及openID时异常，微信内部错误");
        } else {
            //errcode是经验方法，返回errcode表示失败,用状态码来解决
            $loginFail = array_key_exists('errcode', $wxResult);

            if ($loginFail) {

                throw new BaseException([
                    'msg' => $wxResult['errmsg'],
                    'errorCode' => $wxResult['errcode']
                ]);


            } else {

                //生成token
                return $this->grantToken($wxResult);

            }

        }
   }


    private function grantToken($wxResult)
    {

        $openid = $wxResult['openid'];


        //查一下数据库是否有用户记录
        $usermodel = new UserModel();
        $userresult = $usermodel->where('openid','=',$openid)->find();

        if ($userresult) {

            $uid = $userresult->id;
        } else {
            $userinfo = $usermodel->save([
                'openid'=>$openid
            ]);


            $uid = $userinfo->id;
        }

        //缓存
        //key: 令牌
        //value: wxResult , uid, scopeS

        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = 16;

        //生成令牌
        $key = $this->generateToken();
        $value = json_encode($cachedValue);
        $expire_in = Config::get('wx.token_expire_in');

        $request = cache($key, $value, $expire_in);

        if (!$request) {
            throw new BaseException(['msg'=>'服务器缓存异常']);
        }

        return $key;

    }


    private function generateToken()
    {
        $randChars = getRandChar(32);
        //加强加密，用salt符串md5加密
        $salt = Config::get('wx.token_salt');

        return md5($randChars . $salt);
    }


}
