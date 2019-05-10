import { Base } from '../../utils/base.js';

class ThemeModel extends Base
{
  constructor() {
    super();
  }




  getProductsData(count,callback) {
    var params = {
      url: '/api/product/getproductdetail?product_id=' + 11,
      sCallback: function (res) {
        callback && callback(res)
      }
    }

    this.request(params)

  }


}
export {ThemeModel};