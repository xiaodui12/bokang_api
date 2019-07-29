/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./flexible');

window.Vue = require('vue');

import App from './App.vue'
import router from './router'
import store from './store';      // vuex 数据存储所需对象

const app = new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
});
