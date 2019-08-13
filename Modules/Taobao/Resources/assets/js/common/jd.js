import md5 from 'js-md5'
import dayjs from 'dayjs'
import Vue from "vue"
import vueResource from "vue-resource"
Vue.use(vueResource)

//生成签名
function getSign(obj) {
    // var obj = params
    // delete obj.method
    var secret = '77f39e8f3dd147ca94c6b446519ee39a';
    // 字典序排序
    var arr = [];
    for (var a in obj) {
        arr.push(a)
    }
    arr.sort();
    // 拼接
    var str = secret
    for (var i = 0; i < arr.length; i++) {
        str += arr[i];
        str += obj[arr[i]];
    }
    str += secret;
    // md5加密
    str = md5(str).toUpperCase()
    return str;
}

//组合对象
function sortObj(method,param) {
    var data = {
        method,
        param_json:param,
        v: '1.0',
        format:'JSON',
        app_key: 'a6088c069b2f499c9c6cfcfa88aa04d5',
        timestamp: dayjs().format('YYYY-MM-DD HH:MM:ss'),
        sign_method:'md5'
    }
    data.sign = getSign({
        method,
        param
    })
    return data;
}

//查询jd接口
async function jdrequest(method,param) {
    var jd_url = await sortObj(method,JSON.stringify(param))
    var url = 'https://www.70promise.top/backstage/public/index.php/banner'
    return new Promise((resolve, reject) => {
        Vue.http.post(
          url,
          jd_url,
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
    jdrequest
}
