import md5 from 'js-md5'
import dayjs from 'dayjs'
import Vue from "vue"
import vueResource from "vue-resource"
Vue.use(vueResource)

//生成签名
function getSign(obj) {
    var client_secret = '99842b6f4ed6fd3404477928e01a51ca15087a4a';
    // 字典序排序
    var arr = [];
    for (var a in obj) {
        arr.push(a)
    }
    arr.sort();
    // 拼接
    var str = client_secret
    for (var i = 0; i < arr.length; i++) {
        str += arr[i];
        str += obj[arr[i]];
    }
    str += client_secret;
    // md5加密
    str = md5(str).toUpperCase()
    return str;
}

//组合对象
function sortObj(params) {
    params = {
        ...params,
        data_type: 'JSON',
        client_id: '0d1031c489a84e24a67350a5351b3d3b',
        timestamp: dayjs().valueOf(),
    }
    params.sign = getSign(params)
    return params;
}

//查询pdd接口
async function pddrequest(params) {
    var params = await sortObj(params)
    var url = 'https://gw-api.pinduoduo.com/api/router'
    return new Promise((resolve, reject) => {
        Vue.http.post(
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
    sortObj,
    pddrequest
}
