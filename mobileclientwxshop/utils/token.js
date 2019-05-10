import {Base} from 'base.js';
import {Config} from 'config.js';

var app = getApp();

class Token {
    constructor() {
        this.verifyUrl = Config.restUrl + '/api/token/verifytoken'
        this.tokenUrl = Config.restUrl + '/api/token/gettoken'
    }


    verify() {
        var token = app.WxCache.get('token','')

        if (!token) {
            console.log('没有token')
            this.getTokenFromServer();
        } else {
            console.log('验证token')
            var token = app.WxCache.get('token','')
            this.verifyFromServer(token);
        }

    }

    //从服务器获取token
    getTokenFromServer(callBack) {
        var that = this;

        console.log("从服务器获取token")
        wx.login({
            success(res) {

                console.log(res.code)

                wx.request({
                    url: that.tokenUrl,
                    method: 'POST',
                    data : {
                        token_code : res.code
                    },

                    success(res) {

                        console.log(res)
                        app.WxCache.put('token',res.data.token,3600)
                        callBack && callBack(res.data.token)
                    }
                })
            }
        })

    }

    //验证token
    verifyFromServer(token) {
        var that = this

        console.log("token缓存地址是:" + token)

        wx.request({
            url : that.verifyUrl,
            method : "POST",
            data : {
                token : token
            },
            success(res) {

                console.log(res.data)
                var valid = res.data;

                if (!valid) {
                    that.getTokenFromServer()
                }
            }

        })
    }



}

export {Token}