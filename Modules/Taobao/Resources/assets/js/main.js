// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router/index'
import store from '@/store/store'

//引入FastClick(移除点击事件的300ms延迟)
import FastClick from 'fastclick'
FastClick.attach(document.body)

//引入剪切板插件clipboard;
import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)

//引入全局组件
import { ToastPlugin } from 'vux'
Vue.use(ToastPlugin)
import { AlertPlugin } from 'vux'
Vue.use(AlertPlugin)
import { LoadingPlugin  } from 'vux'
Vue.use( LoadingPlugin  )

//全局引入方法--http请求
import request from './http/post'
Vue.prototype.$request = request

//全局引入方法--pdd签名算法
import pdd from './common/pdd'
Vue.prototype.$pdd = pdd

//全局引入方法--tb签名算法
import tb from './common/tb'
Vue.prototype.$tb = tb

//全局引入方法--jd签名算法
import jd from './common/jd'
Vue.prototype.$jd = jd


Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app-box')

