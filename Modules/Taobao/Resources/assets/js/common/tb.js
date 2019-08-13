import md5 from 'js-md5'
import dayjs from 'dayjs'
import Vue from "vue"
import vueResource from "vue-resource"
Vue.use(vueResource)

//生成签名
function getSign(obj) {
    var app_secret = 'bb6a8db3cd997ad744c73d21db4fed66';
    // 字典序排序
    var arr = [];
    for (var a in obj) {
        arr.push(a)
    }
    arr.sort();
    // 拼接
    var str = app_secret
    for (var i = 0; i < arr.length; i++) {
        str += arr[i];
        str += obj[arr[i]];
    }
    str += app_secret;
    // md5加密
    str = md5(str).toUpperCase()
    return str;
}

//组合对象
function sortObj(params) {
    params = {
        ...params,
        sign_method:'md5',
        format: 'json',
        v:'2.0',
        app_key: '27720626',
        timestamp: dayjs().format('YYYY-MM-DD hh:mm:ss')
    }
    params.sign = getSign(params)
    return params;
}

//查询tb接口
async function tbrequest(params) {
    var params = await sortObj(params)
    var url = 'https://api.jd.com/routerjson?v=1.0&method=jd.union.open.category.goods.get&app_key=a6088c069b2f499c9c6cfcfa88aa04d5&access_token=&360buy_param_json=%7B%22req%22%3A%7B%22parentId%22%3A0%2C%22grade%22%3A0%7D%7D&timestamp=2019-08-05%2010%3A37%3A23&sign=3C2F15038EA1DA05F0FA43CA5A84D603'
    return new Promise((resolve, reject) => {
        Vue.http.jsonp(
          url,
          params,
          { emulateJSON: true }
        )
          .then((res) => {
            resolve(res.data);
          })
          .catch((err) => {
            reject(err);
          });
      });
}

export default {
    tbrequest
}
