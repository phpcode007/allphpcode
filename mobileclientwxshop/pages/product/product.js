import { ProductModel } from 'product_model.js';
import {CartModel} from "../cart/cart_model";

var product_model = new ProductModel();

var cart_model = new CartModel();

var storageProductKey = 'cart';

Page({

  /**
   * 页面的初始数据
   */
  data: {
    id:null,
    productCount: 1,
    countsArray : [1,2,3,4,5,6,7,8,9,10],
    product: null,
    current_tabbox_index : 1,
    css_tabbox_index : 1,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var id = options.id;
    this.data.id = id;
    console.log("获取"+id)
    this.loadData()
  },

  loadData: function() {
    product_model.getDetailInfo(this.data.id,(data)=>{

      // console.log("获取的商品是：");
      // console.log(data)

      //获取到某个商品之后，要判断是不是有加入购物车
      // console.log(data.)

      this.setData({
        product:data,
        cartTotalCounts : cart_model.getCartTotalCounts(false,data['id'])
      })
    });


  },


  bindPickerChange: function(event){
    var index = event.detail.value;
    var selectedCount = this.data.countsArray[index];

    this.setData({
      productCount : selectedCount
    })
  },

  onTabsItemTap: function(event) {
    var index = event.currentTarget.dataset.index;
    console.log("获取的点击事件:" + index)

    this.setData({
      currentTabsIndex: index
    })
    // this.setData([
    //   currentTabsIndex: index
    // ]);
  },


  onClickTabBox: function (event) {

    console.log(event)

    var index = event.target.dataset.id

    this.setData({
      current_tabbox_index :  index,
      css_tabbox_index : index,
    })
  },

  //商品数量点击变化处理
  ProductCountChange: function (event) {
    console.log("商品数量变化")
    // console.log(event.detail)
    this.data.productCount = event.detail;
    console.log(this.data.productCount)
  },


  //添加到购物车
  addToCart: function (event) {

    var tempObj = {};
    var keys = ['id','name','main_img_url','price'];


    for (var key in this.data.product) {

      // console.log(this.data.product)

      if (keys.indexOf(key) >= 0) {
        tempObj[key] = this.data.product[key];
        tempObj['selectStatus'] = true;
      }
    }

    // console.log(tempObj)

    cart_model.add(tempObj,this.data.productCount);



    this.setData({
      cartTotalCounts : cart_model.getCartTotalCounts(false,this.data.product['id'])
    })

  }

})