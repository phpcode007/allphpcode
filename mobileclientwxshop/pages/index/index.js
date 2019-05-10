
import { IndexModel } from 'index_model.js';
import {Token} from "../../utils/token";


var index_model = new IndexModel();

//获取应用实例
// const app = getApp()


Page({
  data: {
    

  },
  //事件处理函数
  bindViewTap: function() {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  onLoad: function () {
    
    this.loadData()
    var token = new Token()
    token.verify()


  },


  loadData: function() {
    var id = 1
    index_model.getBannerData(1,(res)=>{
      // console.log("多。。。。。。。层回调来的")
      console.log(res)

      this.setData({
        'bannerArray' : res
      })

    });

    index_model.getThemeData((themeres)=>{
      console.log(themeres)

      this.setData({
        'themeArray': themeres
      })
    });

    index_model.getProductsData(5,(data)=>{

      console.log(data)
      this.setData({
        'productsArr': data
      })
    });
  },


  //处理商品点击事件
  onClickproduct: function(event) {
    console.log(event)

    var id = event.currentTarget.dataset.id;


    wx.navigateTo({
      url: '../product/product?id=' + id,
    })

  },






})
