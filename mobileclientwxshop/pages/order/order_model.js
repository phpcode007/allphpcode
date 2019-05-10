import { Base } from '../../utils/base.js';

class OrderModel extends Base
{
    constructor() {
        super();
    }

    postProductsData(products_data,callback)
    {
        // console.log(products_data)
        // 由于后台接受的都是字符串，所以解决办法就是使用JSON.stringify()格式化数组


        var params = {
            url : '/api/order/placeorder',
            method : 'POST',
            //这里要用数组包围，这样传到后台php才接收到所有数据
            // data :  [{'products' : products_data}],
            data :  [products_data],
            sCallback : function(res) {
                callback && callback(res)
            }
        }

        this.request(params)

    }







}
export {OrderModel};