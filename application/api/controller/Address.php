<?php
namespace app\api\controller;

use app\lib\exception\BaseException;
use think\Exception;
use think\facade\Request;
use app\api\controller\Token;
use app\api\model\User as Usermodel;
use app\api\model\Address as Addressmodel;

class Address  extends Base
{

    public function createOrUpdateAddress()
    {
        $uid = Token::getCurrentUid();

        $user = Usermodel::get($uid);

        if (!$user) {
            throw new BaseException(['msg'=>'用户不存在']);
        }

        $address_model = new Addressmodel();

        $name = Request::param('name');
        $mobile = Request::param('mobile');
        $province = Request::param('province');
        $city = Request::param('city');
        $country = Request::param('country');
        $detail = Request::param('detail');

        $result = $address_model->save([
            'name' => $name,
            'mobile' => $mobile,
            'province' => $province,
            'city' => $city,
            'country' => $country,
            'detail' => $detail

        ],['id'=>$uid]);

        if (!$result) {
            throw new BaseException(['msg' => '地址更新不成功']);
        } else {
            return json(['msg'=>'ok']);
        }

    }


}
