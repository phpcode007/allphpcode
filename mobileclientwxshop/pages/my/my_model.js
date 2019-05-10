import { Base } from '../../utils/base.js';

class MyModel extends Base
{
  constructor() {
    super();
  }



  /*获取服务器token*/
  getServerToken(token_code,callback) {
    var params = {
      url: '/api/token/gettoken?token_code=' + token_code,
      sCallback: function (res) {
        callback && callback(res)
      }
    }

    this.request(params)

  }



  


}
export {MyModel};