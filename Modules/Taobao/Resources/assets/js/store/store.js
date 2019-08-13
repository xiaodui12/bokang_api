// https://vuex.vuejs.org/zh-cn/intro.html
// make sure to call Vue.use(Vuex) if using a module system
import Vue from 'vue'
import Vuex from 'vuex'
import system from './modules/system'
Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        pid: system.state.pid,
        adzone_id: system.state.adzone_id,
        pdd_GZH_pid: system.state.pdd_GZH_pid,
    },
})

export default store
