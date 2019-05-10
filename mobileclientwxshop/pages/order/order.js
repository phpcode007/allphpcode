import {Address} from '../../utils/address.js';
import {OrderModel} from "./order_model";

var address = new Address();
var order_model = new OrderModel();

const app = getApp()
var storageProductKey = 'cart';

Page({

  /**
   * 页面的初始数据
   */
  data: {
    account : 0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    var cart_data = this.getSelectProduct(true);
    console.log(cart_data)

    this.data.account = options.account
    console.log("获取到价格是:" + this.data.account)

    this.setData({
      cart_data : cart_data,
      totalprice : this.data.account,
      orderStatus : 0
    })
  },

  //获取选中的商品
  getSelectProduct: function (selectFlag) {

    var cart_data = app.WxCache.get(storageProductKey, []);
    var newArr = []

    for (var key in cart_data) {

      if (cart_data[key].selectStatus === selectFlag) {
        newArr.push(cart_data[key])
      }

    }

    return newArr

  },



  //编辑收货地址
  submitorder: function (event) {
    // var that = this
    //
    // wx.chooseAddress({
    //   success(res) {
    //     console.log(res)
    //
    //     var addressInfo = {
    //       userName : res.userName,
    //       mobile : res.telNumber,
    //       totalDetail : address.setAddressInfo(res)
    //     }
    //
    //     that.bindAddressInfo(addressInfo)
    //   }
    // })

    // 由于后台接受的都是字符串，所以解决办法就是使用JSON.stringify()格式化数组
    // var products_array = [{'product_id':1,"count":2},{'product_id':3,"count":4},{'product_id':5,"count":6}]
    var products_array = [{"product_id":1,"count":2},{"product_id":3,"count":4},{"product_id":5,"count":6}]


    order_model.postProductsData(products_array,(res)=>{
      console.log(res)
    })

    // index_model.getBannerData(1,(res)=>{
    //   // console.log("多。。。。。。。层回调来的")
    //   console.log(res)
    //
    //   this.setData({
    //     'bannerArray' : res
    //   })
    //
    // });

  },

  bindAddressInfo : function (addressInfo) {

    console.log(addressInfo)
    this.setData({
      addressInfo : addressInfo
    })
  }

})