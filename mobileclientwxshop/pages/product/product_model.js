import { Base } from '../../utils/base.js';

class ProductModel extends Base
{
  constructor() {
    super();
  }




  getDetailInfo(product_id,callback) {
    var params = {
      url: '/api/product/getproductdetail?product_id=' + product_id,
      sCallback: function (res) {
        callback && callback(res)
      }
    }

    this.request(params)

  }


}
export { ProductModel};