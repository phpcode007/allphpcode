import { Cart } from '../cart/cart_model.js'
import {CartModel} from "../cart/cart_model";

import Dialog from '../vant/dialog/dialog';

var cart_model = new CartModel();

const app = getApp()

var storageProductKey = 'cart';

// const deletemessage = '有赞是一家零售科技公司，致力于成为商家服务领域里最被信任的引领者';

Page({

  /**
   * 页面的初始数据
   */
  data: {
    cartData : [],
    account : 0,
    all_selectStatus : true,
    totalprice : 0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    //只执行一次
  },

  onShow: function () {
    var cartData = app.WxCache.get(storageProductKey, []);

    // let checkedproductid = "checkedproduct" +

    console.log(cartData)
    this.setData({
      cartData : cartData
    })

    let is_all_select = true


    //判断是不是全选
    for (let key in cartData) {
      // console.log(cartData[key])
      if (cartData[key].selectStatus === false) {
        is_all_select = false

        //这里不break,因为要算选中商品的总价
        break;
      }

    }

    this.setData({
      all_selectStatus : is_all_select,
      totalprice : this.cale_totoal_price(cartData)
    })


  },


    /*

    重做。。。。。。。。。。。。。。。。。。。。。。。。。。。
     */


  ChangeProductSelected: function (event) {

    let product_id = event.currentTarget.dataset.id;


      const { key } = event.currentTarget.dataset;
      this.setData({ [key]: event.detail });


      this.setData({
        totalprice : this.cale_totoal_price(cartData)
      })
  },

  //选择某一个商品
  toggleSelect: function (event) {


    let clickproductdatalenght = this.data.cartData.length
    let cart_data = this.data.cartData

    for (let i = 0; i < clickproductdatalenght; i++) {
      // console.log(this.data.cartData[i])
      if (cart_data[i].id == event.currentTarget.dataset.id) {
        console.log("选中了" + cart_data[i].selectStatus)
        console.log(cart_data[i])

        cart_data[i].selectStatus = !cart_data[i].selectStatus;
      }




    }


    this.setData({
      cartData: cart_data,
      // totalprice : this.data.totalprice.toFixed(2)
      totalprice : this.cale_totoal_price(cart_data)

    })



    //*******************************************************

    // let cart_data = this.data.cartData
    let is_all_select = true


    //判断是不是全选
    for (let key in cart_data) {

      if (cart_data[key].selectStatus === false) {
        is_all_select = false
        break;
      }

    }

    this.setData({
      all_selectStatus : is_all_select
    })


    app.WxCache.remove(storageProductKey)
    app.WxCache.put(storageProductKey,cart_data)

  },


  //改变某个商品数量
  ChangeProductCount: function (event) {

    let clickproductdatalenght = this.data.cartData.length
    let cart_data = this.data.cartData

    for (let i = 0; i < clickproductdatalenght; i++) {
      if (cart_data[i].id == event.currentTarget.dataset.id) {

        console.log("选中了" + cart_data[i].counts)

        cart_data[i].counts = event.detail;
      }
    }


    // console.log(cart_data)

    this.setData({
      cartData: cart_data,
      totalprice : this.cale_totoal_price(cart_data)
    })


    app.WxCache.remove(storageProductKey)
    app.WxCache.put(storageProductKey,cart_data)
  },

  deleteproductbyid: function (event) {
    // console.log(event.target.dataset.id)

    Dialog.confirm({
      // title: '标题',
      message: '你是否想删除这个商品?'
    }).then(() => {
      // on confirm
      console.log("点击确认了")



      let product_id = event.target.dataset.id
      console.log(event)

      let clickproductdatalenght = this.data.cartData.length
      let cart_data = this.data.cartData




      for (let i = 0; i < clickproductdatalenght; i++) {
        if (cart_data[i].id == product_id) {

          console.log("选中了" + event.target.dataset.id)
          console.log("i的值 是:" + i)

          cart_data.splice(i,1)
          // cart_data.pop()

          break;
        }
      }



      this.setData({
        cartData : cart_data,
        totalprice : this.cale_totoal_price(cart_data)
      })

      app.WxCache.remove(storageProductKey)
      app.WxCache.put(storageProductKey,cart_data)






    }).catch(() => {
      // on cancel
      console.log("取消")
    });






  },


  //全选商品
  allproductclick: function (event) {

    // let status = event.currentTarget.dataset.status


    console.log("status的结果是:" + this.data.all_selectStatus)

    let cart_data = this.data.cartData

    // let result = !status

    // console.log("result的结果是：" + status)

    for (var key in cart_data) {
      cart_data[key].selectStatus = !this.data.all_selectStatus
    }

    this.setData({
      cartData : cart_data,
      all_selectStatus : !this.data.all_selectStatus,
      totalprice : this.cale_totoal_price(cart_data)
    })
  },


  //计算所有选中商品的总价
  cale_totoal_price : function (cartData) {

    var totalprice = 0
    var multiple = 100

    //判断是不是全选
    for (let key in cartData) {
      //计算所有选中商品的总价
      // js浮点计算bug，取两位小数精度
      //避免 0.05 + 0.01 = 0.060 000 000 000 000 005 的问题，乘以 100 *100

      if(cartData[key].selectStatus === true) {
        totalprice += cartData[key].counts * multiple *  Number(cartData[key].price)*multiple;

      }


      // console.log("函数总共的价格是：" + totalprice)


    }

    return totalprice/(multiple*multiple)
  },

  //提交订单
  submitorder: function (event) {
    wx.navigateTo({
      url: '../order/order?account=' + this.data.totalprice + '&from=cart'
    })
  }











})