import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

//引入组件

//拼多多首页
import pdd_home from '@/pages/pdd_home'
//拼多多搜索
import pdd_search from '@/pages/pdd_search'
//拼多多商品详情
import pdd_detail from '@/pages/pdd_detail'
//拼多多分类
import pdd_kind from '@/pages/pdd_kind'
//淘宝首页
import taobao_home from '@/pages/taobao_home'
//淘宝搜索
import taobao_search from '@/pages/taobao_search'
//淘宝商品详情
import taobao_detail from '@/pages/taobao_detail'


export default new Router({
  routes: [
    {
      path:'',
      redirect:'/taobao',
    },
    {
      path: '/pdd',
      name: '拼多多',
      component: pdd_home
    },
    {
      path: '/pdd/pdd_search',
      name: '拼多多搜索',
      component: pdd_search
    },
    {
      path: '/pdd/pdd_kind',
      name: '拼多多分类',
      component: pdd_kind
    },
    {
      path: '/pdd/pdd_detail',
      name: '拼多多商品详情',
      component: pdd_detail
    },
    {
      path: '/taobao',
      name: '淘宝',
      component: taobao_home
    },
    {
      path: '/taobao/taobao_search',
      name: '淘宝搜索',
      component: taobao_search
    },
    {
      path: '/taobao/taobao_detail',
      name: '淘宝商品详情',
      component: taobao_detail
    },

  ]
})
