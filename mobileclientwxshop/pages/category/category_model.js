import { Base } from '../../utils/base.js';

class CategoryModel extends Base
{
  constructor() {
    super();
  }



  /*获得所有分类*/
  getCategoryType(callback) {
    var params = {
      url: '/api/category/getallcategories',
      sCallback: function (res) {
        callback && callback(res)
      }
    }

    this.request(params)

  }



  // /*获得单一分类的头图*/
  // getCategoryOne(id ,callback) {
  //   var params = {
  //     url: '/api/category/changeCategories?id=' + id,
  //     sCallback: function (res) {
  //       callback && callback(res)
  //     }
  //   }
  //
  //   this.request(params)
  //
  // }

  getProductsByCategory(id,callback) {
    var params = {
      url: '/api/product/getallincategory?id=' + id,
      sCallback: function (res) {
        callback && callback(res)
      }
    }

    this.request(params)
  }

  


}
export { CategoryModel};