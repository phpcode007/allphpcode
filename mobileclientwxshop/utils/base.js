import {Config} from 'config.js'

class Base
{
  constructor(){
    this.baseRequestUrl = Config.restUrl;
  }

  request(params){

    var url = this.baseRequestUrl + params.url;

    if(!params.type) {
      params.type = 'GET'
    }

    console.log("toekn缓存的地址是:" + wx.getStorageSync('token'));

    wx.request({
      url: url,
      data: params.data,
      header: {
        'content-type' : 'application/json',
        'token': wx.getStorageSync('token')
      },
      method: params.type,
      dataType: 'json',
      responseType: 'text',
      success: function(res) {

        console.log(res)


        if(params.sCallback) {
          params.sCallback(res.data)
        }

      },
      fail: function(err) {
        console.log(err)
      },
    })
  }


  getDataSet(event,key) {
    return event.currentTarget.dataset[key];
  }

}


export {Base};