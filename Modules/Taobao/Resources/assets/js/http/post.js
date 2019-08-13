import md5 from 'js-md5'
import dayjs from 'dayjs'
import Vue from "vue"
import vueResource from "vue-resource"
Vue.use(vueResource)


var API_PATH = {
  'prod':'/api/',
  
  // 'base': 'bokang',//开发环境
  'base': 'https://pingoufan.com/',//正式环境
  'pdd': 'https://gw-api.pinduoduo.com/api/router',
  'taobao': 'http://bokang.chuangchengkj.cn/taobao/getutil' ,//向后端发送请求
  // 'prod': 'https://www.70promise.top/backstage/public/index.php/' //测试用
}

//通用post请求
function post(url, params, prefix) {
  url = API_PATH[prefix] + url
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

//淘宝请求（get）
function taobao(params) {
  var url = API_PATH['taobao']
  return new Promise((resolve, reject) => {
    Vue.http.get(
      url,
      {params}
    )
      .then((res) => {
        resolve(res.data);
      })
      .catch((err) => {
        reject(err);
      });
  });
}


//生成签名md5
function getSign(secret,obj) {
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

//组合pdd对象
function sortPddObj(params) {
  params = {
      ...params,
      data_type: 'JSON',
      client_id: '0d1031c489a84e24a67350a5351b3d3b',
      timestamp: dayjs().valueOf(),
  }
  var client_secret = '99842b6f4ed6fd3404477928e01a51ca15087a4a';
  params.sign = getSign(client_secret,params)
  return params;
}

//查询pdd接口
async function pdd(params) {
  var params = await sortPddObj(params)
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
  post,
  pdd,
  taobao
}


