import {Base} from 'base.js';

class Address extends Base {
    constructor(props) {
        super(props);
    }

    //设置地址
    //一种是微信返回的
    //一种是从自己服务器返回的
    //用同一个函数处理
    setAddressInfo(res) {
        var province = res.provinceName || res.province
        var city = res.cityName || res.city
        var country = res.countyName || res.country
        var detail = res.detailInfo || res.detail

        var totalDetail = city + country + detail

        if (this.isCenterCity(province)) {
            totalDetail = province + totalDetail
        }

        return totalDetail
    }

    isCenterCity(name) {
        var centerCitys = ['北京市','天津市','上海市','重庆市']

        var flag = centerCitys.indexOf(name) >=0

        return flag
    }
}

export {Address}