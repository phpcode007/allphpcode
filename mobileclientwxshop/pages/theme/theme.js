// pages/theme/theme.js
import { ThemeModel } from 'theme_model.js';

var theme_model = new ThemeModel();


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
    var id = options.id;
    var name = options.name;

    //保存到全局data中
    this.data.id = id;
    this.data.name = name;



    console.log('id=' + id + 'name=' + name)

    this.loaddata()
  },

  //放到这里设置头部，防止没有获取到头部
  onReady: function() {
    wx.setNavigationBarTitle({
      title: this.data.name,
    })
  },

  loaddata: function()
  {
    theme_model.getProductsData(this.data.id,(data)=>{

      console.log(data)

      this.setData({
        'themeInfo' : data
      })
    })
  }



})