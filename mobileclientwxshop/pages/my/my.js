import { MyModel } from 'my_model.js';

var my_model = new MyModel();

const app = getApp()


Page({

  /**
   * 页面的初始数据
   */
  data: {

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    this.getToken()

  },


  getToken: function () {
    wx.login({
      success: function (res) {
        var token_code = res.code;

        console.log("微信code是：" + token_code)

        my_model.getServerToken(token_code,(res)=>{
            console.log(res)

            app.WxCache.put('token',res,7200)
        })
      }
    })

  }
})