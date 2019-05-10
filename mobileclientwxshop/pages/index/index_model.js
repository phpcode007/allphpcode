import { Base } from '../../utils/base.js';

class IndexModel extends Base
{
  constructor() {
    super();
  }

  getBannerData(id,callback)
  {
    var params = {
      url : '/api/banner/index?id=' + id,
      sCallback : function(res) {
        callback && callback(res)
      }
    }

    this.request(params)

  }

  getThemeData(callback) {
    var params = {
      url: '/api/theme/getSimpleList?ids=1,2,3',
      sCallback: function (res) {
        callback && callback(res)
      }
    }

    this.request(params)

  }


  getProductsData(count,callback) {
    var params = {
      url: '/api/product/index?product_count=' + count,
      sCallback: function (res) {
        callback && callback(res)
      }
    }

    this.request(params)

  }


}
export {IndexModel};