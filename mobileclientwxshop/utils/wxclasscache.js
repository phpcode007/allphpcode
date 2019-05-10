/**
 * name: wx-class-cache.js
 * description: 微信缓存二次封装，有设置时效性的封装
 *

 */

export default class WxCache {

    constructor() {
        this.dtime = '_deadtime';
    }

    put(k, v, t) {
        wx.setStorageSync(k, v)
        var seconds = parseInt(t);
        if (seconds > 0) {
            var timestamp = Date.parse(new Date());
            timestamp = timestamp / 1000 + seconds;
            wx.setStorageSync(k + this.dtime, timestamp + "")
        } else {
            wx.removeStorageSync(k + this.dtime)
        }
    }

    get(k, def) {
        var deadtime = parseInt(wx.getStorageSync(k + this.dtime))
        if (deadtime) {
            if (parseInt(deadtime) < Date.parse(new Date()) / 1000) {
                if (def) {
                    return def;
                } else {
                    return;
                }
            }
        }
        var res = wx.getStorageSync(k);
        if (res) {
            return res;
        } else {
            return def;
        }
    }

    remove(k) {
        wx.removeStorageSync(k);
        wx.removeStorageSync(k + this.dtime);
    }

    clear() {
        wx.clearStorageSync();
    }

}