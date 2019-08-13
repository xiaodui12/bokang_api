<template>
  <div id="app">
    <router-view></router-view>
    <tabbar
      style="position:fixed;bottom:0;z-index:99999;"
      :style="isshowtabbar? 'display:none' : 'display:none'"
    >
      <tabbar-item selected :link="{path:'/taobao',replace:true}">
        <img slot="icon" src="@/assets/taobao_default.png" />
        <img slot="icon-active" src="@/assets/taobao_active.png" />
        <span slot="label">淘宝</span>
      </tabbar-item>
      <tabbar-item :link="{path:'/jingdong',replace:true}">
        <img slot="icon" src="@/assets/jingdong_default.png" />
        <img slot="icon-active" src="@/assets/jingdong_active.png" />
        <span slot="label">京东</span>
      </tabbar-item>
      <tabbar-item  :link="{path:'/pdd',replace:true}">
        <img slot="icon" src="@/assets/pdd_default.png" />
        <img slot="icon-active" src="@/assets/pdd_active.png" />
        <span slot="label">拼多多</span>
      </tabbar-item>
    </tabbar>
  </div>
</template>

<script>
import { ViewBox, Tabbar, TabbarItem } from "vux";

export default {
  name: "app",
  components: {
    Tabbar,
    TabbarItem,
    ViewBox
  },
  computed: {
    isshowtabbar() {
      if (
        this.$route.path == "/pdd" ||
        this.$route.path == "/taobao" ||
        this.$route.path == "/jingdong"
      ) {
        return true;
      } else {
        return false;
      }
    }
  },
  methods: {},
  async mounted() {
    // this.$http.jsonp('http://bokang.chuangchengkj.cn/taobao/getutil').then(function(response){
    //     this.$set('gridData', response.data)
    // })
  }
};
</script>

<style lang="less">
@import "~@/style/icon.less";
html,
body {
  background: #f2f2f2;
  text-align: center;
  margin: 0;
  padding: 0;
  color: #333;
}
#app {
  width: 100%;
}
div,
button,
input,
textarea,
label,
img {
  box-sizing: border-box;
}
img{
  display: block;
}
a {
  text-decoration: none;
}
p {
  display: block;
  margin-block-start: 0;
  margin-block-end: 0;
  margin-inline-start: 0px;
  margin-inline-end: 0px;
}
</style>
