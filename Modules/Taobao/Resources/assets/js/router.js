import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            name: "index",
            path: '/',
            component: resolve => require(['./views/index/index.vue'], resolve),
            meta: {
                keepAlive: false // 不需要缓存
            }
        }
    ]
})
