<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26
 * Time: 17:35
 */
namespace app\lib\validate;

use app\lib\exception\BaseException;
use think\facade\Request;
use think\Validate;

use think\Response;
use think\exception\HttpResponseException;


class JDShopValidate extends Validate
{

    protected $rule = [

        //特别注意，|做分隔线不有空格，如果有空格会出现问题

        //公共id
        'id' => 'require|zhengzhengshu',


        //Theme控制器的方法getSimpleList
        'ids' => 'require|checkIDS',



        //Category控制器的方法add
        'cname' => 'require|chsAlphaNum',
        'parent_id' => 'require|number',
        'isrec' => 'require|number',

        //Goods控制器的方法add
        'goods_name' => 'require|chsAlphaNum',
        'goods_sn' => 'chsAlphaNum',
        'cate_id' => 'require|checkCategoryId',
        'market_price' => 'require|float',
        'shop_price' => 'require|float',
        'is_sale' => 'require|number',
        'is_hot' => 'number',
        'is_new' => 'number',
        'is_rec' => 'number',
//        'goods_img' => 'file',
        'goods_body' => 'require|chsAlphaNum',

        //role控制器的方法add
        'role_name' => 'require|chsAlphaNum',

        //admin控制器的方法add
        'username' => 'require|chsAlphaNum',
        'password' => 'require|chsAlphaNum',
        'role_id' => 'require|number',

        //admin控制器的方法del
        'admin_id' => 'require|number',


        //rule控制器的方法add
        'rule_name' => 'require|chsAlphaNum',
        'module_name' => 'require|chsAlphaNum',
        'controller_name' => 'require|chsAlphaNum',
        'action_name' => 'require|chsAlphaNum',
        'parent_id' => 'require|integer',
        'is_show' => 'require|boolean',

        //type控制器的方法add
        'type_name' => 'require|chsAlphaNum',

        'product_count' =>'require|chsAlphaNum|between:1,15',


        //Token令牌控制器的方法getToken
        'token_code' => 'require|chsAlphaNum',

        //Product控制器的方法getProductDetail
        'product_id' => 'require|number',

        //Order控制器的订单数量验证
        //不要漏了require,漏了后面的checkProducts不生效
        'products' => 'require|checkProducts',

    ];

    //单独为商品数组做的规则,需要手动调用
    protected $singleRule = [
        'product_id' => 'require|zhengzhengshu',
        'count' => 'require|zhengzhengshu'
    ];

    protected $message = [

        //Theme控制器的方法getComlexOne
        'id' => 'id必须是正整数',
        'cname' => '分类名称 : 必须是汉字、字母和数字',
        'parent_id' => 'parent_id必须是正整数',
        'isrec' => '是否推荐 : 必须选择，而且是正整数',

        //Goods控制器的方法add
        'goods_name' => '商品名称 : 必须是汉字、字母和数字',
        'goods_sn' => '商品货号 : 必须是汉字、字母和数字',
        'cate_id' =>   '分类名称 : 必须要选择一个分类',
        'shop_price' => '本店售价: 必须是数字',
        'is_sale' => '是否上架: 必须是数字',
        'is_hot' => '热卖：必须是数字',
        'is_new' => '新品：必须是数字',
        'is_rec' => '推荐：必须是数字',
        'market_price' => '市场售价：必须是价格格式',
//        'goods_img' => '商品图片：必须上传',
        'goods_body' => '商品描述：必须填写',



        //role控制器的方法add
        'role_name' => '角色名称必须填写',

        //admin控制器的方法add
        'username' => '用户名不能为空',
        'password' => '密码不能为空',
        'role_id' => '角色id不能为空',

        //admin控制器的方法del
        'admin_id' => '管理员id不能为空',


        //rule控制器的方法add
        'rule_name' => '权限名称必须是汉字、字母和数字',
        'module_name' => '模块名称必须是汉字、字母和数字',
        'controller_name' => '控制器名称必须是汉字、字母和数字',
        'action_name' => '方法名称必须是汉字、字母和数字',
        'parent_id' => '顶级权限必须是数字',
        'is_show' => '是否显示必须true或flase',

        //type控制器的方法add
        'type_name' => '类型名称必须是汉字、字母和数字',

        //product控制器的方法new
        'product_count' => '参数只能是数字，而且是1到15',


        'token_code' => '类型名称必须是汉字、字母和数字',


        //Product控制器的方法getProductDetail
        'product_id' => '参数只能是数字',


        //Theme控制器的方法getSimpleList
        'ids' => 'ids参数必须为以逗号分隔的多个正整数',


        'products' => '商品参数有问题33333333333',


    ];

    protected $scene = [

        //公共的id
        'Common_id' => ['id'],

        //Category控制器的方法add
        'Category_add' => ['cname','parent_id','isrec'],
        //Category控制器的方法del
        'Category_del' => ['id'],
        //Category控制器的方法edit_get
        'Category_edit_get' => ['id'],
        //Category控制器的方法edit_post
        'Category_edit_post' => ['id'],

        //Goods控制器的方法add
        'Goods_add' => ['goods_name','goods_sn','cate_id','market_price','shop_price','is_sale',
                        'is_rec','is_hot','is_new','goods_body'],



        //role控制器的方法add
        'Role_add' => ['role_name'],

        //role控制器的方法edit
        'Role_edit' => ['id','role_name'],


        //admin控制器的方法add
        'Admin_add' => ['role_id','username','password'],

        //admin控制器的方法del
        'Admin_del' => ['admin_id'],

        //admin控制器的方法edit_get
        'Admin_edit_get' => ['admin_id'],

        //admin控制器的方法edit_post
        'Admin_edit_post' => ['admin_id','username','role_id'],


        //rule控制器的方法add
        'Rule_add' => ['rule_name','module_name','controller_name','parent_id','is_show'],

        //type控制器的方法add
        'Type_add' => ['type_name'],

        //type控制器的方法edit
        'Type_edit' => ['Common_id'],



        ################################################# API ####################################################################

        'banner_index' => ['id'],

        'Theme_index' => ['id'],

        'Product_new' => ['product_count'],


        'Token_code' => ['token_code'],


        //Product控制器的方法getProductDetail
        'Product_getProductDetail' => ['product_id'],


        //Theme控制器的方法getSimpleList
        'Theme_getSimpleList' => ['ids'],



        'Product_getAllInCategory' => ['id'],


        //Order控制器的订单数量验证
        'Order_placeOrder' => ['products'],
    ];




    protected function checkCategoryId($value, $rule='', $data='', $field='')
    {
        $value = intval($value);

        if ($value>0) {
            return true;
        } else {
            return false;
        }
    }



    public function goCheck($scene='',$resulttype=false)
    {
        //先获取请求参数
        $request = Request::instance();
        $params = $request->param();

        //需要批量验证
        //判断是否有传场景进来验证
        if ($scene) {
            $request = $this->scene($scene)->batch()->check($params);
        } else {
            $request = $this->batch()->check($params);
        }

        //看看是否需要抛出异常

        //由于我们已经写好了全局异常类，不需要管什么异常，反正抛出去就可以了。
        if (!$request) {
//            throw new ParameterException([
//                'msg'=>$this->error,
//            ]);

            //先创建一个异常，不创建一个新文件了，到时会导致文件很多，异常也很多。
            //直接重写基类生成异常

            //验证失败错误信息$this->error是从Validate获取的，默认就有，不需要管
//            $e = new BaseException([
////                'code'=>400,
//
//                //也不需要每次都写code和errorCode
//                //只写一个error错误信息就可以了,方便很多
//                'msg'=>$this->error,
////                'errorCode' =>999]
//                ]
//            );
//
//            throw $e;


//            halt($this->getError());


            if ($resulttype) {
                throw new BaseException(['msg'=>$this->getError()]);
            } else {

//                halt($this->getError());
                return $this->getError();
            }



        } else {
            return true;
        }
    }

    //验证正整数，而且需要大于0，不能是小数,用于数据库自增ID
    public function zhengzhengshu($value)
    {
        if ((is_int($value) || ctype_digit($value)) && (int)$value> 0 ) {//int
            return true;
        } else {
            return false;
        }
    }

//    protected function isPositiveInteger($value, $rule='', $data='', $field='')
//    {
//        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
//            return true;
//        }
//        return false;
//    }

    protected function checkIDS($value)
    {
        $values = explode(',', $value);
        if (empty($values)) {
            return false;
        }
        foreach ($values as $id) {
            if (!$this->zhengzhengshu($id)) {
                // 必须是正整数
                return false;
            }
        }
        return true;
    }


    //验证商品数组
    protected function checkProducts($values)
    {

        echo 'uuuuuuuuuuu';
        return true;

        if (!is_array($values)) {
            throw new BaseException(['msg'=>'111111111商品参数不正确']);
        }

        if (empty($values)) {
            throw new BaseException(['msg'=>'商品列表不能为空2222222222']);
        }

        foreach ($values as $value) {
            $this->checkProduct($value);
        }

        return true;

    }

    //单独验证商品数组
    protected function checkProduct($value)
    {
        //这里又重新实例一次当前类
        //这是验证器另外一种使用方法
        $validate = new JDShopValidate($this->singleRule);
        $result = $validate->check($value);

        if (!$result) {
            throw new BaseException(['msg'=>'商品列表参数错误']);
        }
    }
}