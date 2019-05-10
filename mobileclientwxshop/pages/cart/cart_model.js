import { Base } from '../../utils/base.js';

const app = getApp()

class CartModel extends Base
{
  constructor() {
    super();
    this.storageKeyName = 'cart';
    // this.cartData = [];
  }

  /*
  * 加入到购物车
  * 如果之前没有样的商品，则直接添加一条新的记录， 数量为 counts
  * 如果有，则只将相应数量 + counts
  * @params:
  * item - {obj} 商品对象,
  * counts - {int} 商品数目,
  * */
  add(item, counts) {

    var cartData = app.WxCache.get(this.storageKeyName,[])

    var hasProduct = false
    // console.log(cartData)

    //先判断缓存中有没有对应的商品id
    for (var key in cartData) {
      console.log(cartData[key])

      if (cartData[key].id == item.id) {

        hasProduct = true
        break;
      }

    }

    if (hasProduct) {
      cartData[key].counts = cartData[key].counts + counts
    } else {
      item.counts = counts
      cartData.push(item);
    }


    app.WxCache.remove(this.storageKeyName)
    app.WxCache.put(this.storageKeyName,cartData)











    // if (cartData.length === 0) {
    //
    //   console.log("空的商品缓存")
    //   item.counts = counts
    //   item.selectStatus = true; //设置选中状态
    //   app.WxCache.put(this.storageKeyName,item)
    //
    // } else {
    //
    //   for (var key in cartData) {
    //
    //     console.log(cartData)
    //
    //     if (cartData[key] == item.id) {
    //       // cartData[key].counts += cartData[key].counts
    //       // app.WxCache.put(this.storageKeyName,cartData)
    //
    //       console.log("选中的商品是:" + item.id)
    //
    //     }
    //
    //   }
    //
    // }






    // //动态语言麻烦的一点在这里，item.id是后面添加的，有时完全不知道在哪里又有一个item.id属性
    // var isHasInfo = this.isHasThatOne(item.id,cartData)
    //
    // if (isHasInfo.index == -1) {
    //   //这是动态语言的灵活性，又添加了一个属性，但是查起来比较麻烦
    //   item.counts = counts;
    //   item.selectStatus = true; //设置选中状态
    //
    //   cartData.push(item)
    //   app.WxCache.put(this.storageKeyName,cartData)
    // } else {
    //   //因为下面那个函数返回值中有一个index属性
    //   cartData[isHasInfo.index].counts += counts;
    // }



  }

  isHasThatOne(id, arr) {

    var item = null;
    var result = {index : -1};

    for (let i = 0; i<arr.length; i++) {
      item = arr[i];

      if (item.id == id) {
        result = {index: i, data: item}
      }

      break;
    }

    return result;

  }

  //计算商品总数
  //flag true 商品选择状态
  getCartTotalCounts(flag,productid) {
    var data = app.WxCache.get(this.storageKeyName, []);

    console.log(data)

    var counts = 0;

    for (let i = 0; i < data.length; i++) {

      if (flag) {

        if(data[i].selectStatus) {

          counts += data[i].counts;

        }

      } else {

        console.log("商品的id是:" + data[i].id)
        if(data[i].id == productid) {
          counts += data[i].counts;

        }

      }
    }

    return counts;
  }





}
export { CartModel};