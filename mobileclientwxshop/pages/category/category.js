import { CategoryModel } from 'category_model.js';

var category_model = new CategoryModel();

const app = getApp()



Page({

  /**
   * 页面的初始数据
   */
  data: {
    currentTabsIndex : 0,
    categoryData : null
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.loadData();
  },

  loadData: function() {
    category_model.getCategoryType((categoryData)=>{
      //要放在第一次回调函数里边，这样才可以保证拿到数据

        this.categoryData = categoryData;

      category_model.getProductsByCategory(categoryData[0].id,(data)=>{

        // xjq();
        var dataObj = {
          products: data.products,
          topImgUrl : categoryData[0].topic_img_url,
          title : categoryData[0].name
        }

        console.log(dataObj)
        // console.log(categoryData[0].id)

        this.setData({
          categoryInfo : dataObj,
          css_category_index : categoryData[0].id
          })
      })

      this.setData({
        categoryTypeArr : categoryData
      });
    });



  },

  changeCategory: function (event) {


    // app.WxCache.put('xjq','默认的值234243',300)
    // console.log("缓存的内容: " + app.WxCache.get('xjq',''))

    var id = event.currentTarget.dataset.id;
    console.log(event.currentTarget.dataset.id)
    console.log("当前页数:"+ this.data.currentTabsIndex)

    if (id == this.data.currentTabsIndex) {
      console.log("重复点击，不用再请求数据")
      return;
    }

    this.data.currentTabsIndex = id;

    var dataObj = app.WxCache.get('dataObj_'+id)

    if(dataObj) {
      console.log("获取到缓存有值")
      this.setData({
        categoryInfo : dataObj,
        css_category_index : this.data.currentTabsIndex
      })

      return;

    }




    category_model.getCategoryType((categoryData)=>{
      //要放在第一次回调函数里边，这样才可以保证拿到数据
      category_model.getProductsByCategory(id,(data)=>{

          console.log(this.currentTabsIndex)

        var dataObj = {
          products: data.products,
          topImgUrl : categoryData[0].topic_img_url,
          // title : categoryData[0].name
          //   title : this.data.categoryData[this.data.currentTabsIndex].name
        }

        app.WxCache.put('dataObj_'+ id,dataObj,3600)

        console.log(dataObj)

        this.setData({
          categoryInfo : dataObj
        })
      })

      this.setData({
        categoryTypeArr : categoryData
      });
    });

  },

  clickproduct: function (event) {

     var id = event.currentTarget.dataset.id;
    console.log(event.currentTarget.dataset.id)

      wx.navigateTo({
          url: '../product/product?id=' + id,
      })
  }

})