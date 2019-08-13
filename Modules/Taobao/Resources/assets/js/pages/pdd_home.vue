<template>
  <div class="pdd_home">
    <!-- 顶部固定导航栏 -->
    <div id="bar-fixed">
      <!-- 搜索 -->
      <search position="absolute" :auto-fixed="false" @on-focus="search" ref="search"></search>
      <!-- 导航栏 -->
      <div style="width:100%;background:#fff">
        <tab :line-width="0" active-color="#ff4141">
          <tab-item
            :selected="index == 0"
            active-class="tab-active"
            v-for="(item,index) in optList"
            :key="index"
            @on-item-click="tabChange"
          >{{ item.opt_name }}</tab-item>
        </tab>
      </div>
    </div>
    <div :style="'height:' + barHeight + 'px'"></div>
    <!-- 轮播图 -->
    <swiper :list="swiperList" :v-model="1" loop v-if="opt_id == 0"></swiper>
    <!-- 分类宫格 -->
    <!-- <grid :cols="5" :show-lr-borders="false" :show-vertical-dividers="false" id="grid">
      <grid-item v-for="i in 10" :key="i">
        <img slot="icon" src="../assets/logo.png" />
        <span class="grid-center">grid{{i}}</span>
      </grid-item>
    </grid>-->
    <goodlist :goodList="goodList" :isTitle="opt_id==0"></goodlist>
  </div>
</template>

<script>
//部分引入vux组件
import { Search, Grid, GridItem, Tab, TabItem, Swiper } from "vux";
//引入商品列表组件
import goodlist from "@/components/pddgoodlist";
import { create } from "domain";

export default {
  name: "pdd",
  components: {
    Search,
    Grid,
    GridItem,
    Tab,
    TabItem,
    Swiper,
    goodlist
  },
  computed: {
    swiperList() {
      return this.themeList.map(item => {
        var url = "/pdd/pdd_search" + "?" + "theme_id" + item.id;
        var img = item.image_url;
        var title = item.name;
        return {
          url,
          img,
          title
        };
      });
    }
  },
  data() {
    return {
      //默认商品列表为全部商品
      opt_id: 0,
      page: 1,
      goodList: [],
      themeList: [],
      optList: [],
      barHeight: 0
    };
  },
  methods: {
    //页面滚动
    onScroll() {
      //页面滚动触底
      let innerHeight = document.querySelector("#app").clientHeight; // 可滚动容器的高度
      let outerHeight = document.documentElement.clientHeight; // 屏幕尺寸高度
      let scrollTop = document.documentElement.scrollTop; // 可滚动容器超出当前窗口显示范围的高度
      if (outerHeight + scrollTop == innerHeight) {
        // 加载更多操作
        this.pddDdkGoodsSearch(this.opt_id);
      }
    },
    //点击跳转搜索页面
    search() {
      this.$router.push({ path: "/pdd/pdd_search" });
    },
    //点击切换tab
    tabChange(index) {
      this.goodList = [];
      this.page = 1;
      this.opt_id = this.optList[index].opt_id;
      this.pddDdkGoodsSearch(this.opt_id);
    },
    //多多进宝主题列表查询
    async pddDdkThemeListGet() {
      var res = await this.$pdd.pddrequest({
        type: "pdd.ddk.theme.list.get",
        page_size: 5,
        page: 1
      });
      this.themeList = res.theme_list_get_response.theme_list;
    },
    //多多进宝商品列表查询
    async pddDdkGoodsSearch(opt_id) {
      var res = await this.$pdd.pddrequest({
        type: "pdd.ddk.goods.search",
        opt_id,
        page_size: 20,
        page: this.page
      });
      this.goodList = this.goodList.concat(
        res.goods_search_response.goods_list
      );
      this.page = this.page + 1; //成功获取商品列表后，页码加一
    },
    //请求后台接口————获取拼多多类目
    async pddGoodsOptGet() {
      var res = await this.$request.post(
        "/pdd/getclass",
        {
          token: "06ddb04f25956f1ff1275049d065939e"
        },
        "base"
      );
      this.optList = res.data;
    }
  },
  async created() {
    // 监听滚动事件
    window.addEventListener("scroll", this.onScroll);
  },
  async mounted() {
    //获取顶部搜索栏和导航栏高度
    this.barHeight = document.querySelector("#bar-fixed").clientHeight;
    this.pddGoodsOptGet();
    this.pddDdkThemeListGet();
    this.pddDdkGoodsSearch(this.opt_id);
    var _this = this;
    // var pdd_pid = await this.$jd.jdrequest("jd.union.open.category.goods.get",{
    //   req: {
    //     parentId: 0,
    //     grade: 0
    //   }
    // });
    // var pdd_pid = await this.$tb.tbrequest({
    // });
    //创建多多进宝推广位
    // var pdd_pid = await this.$pdd.pddrequest({
    //   type: "pdd.ddk.goods.pid.generate",
    //   number: 1
    // });
    // console.log(pdd_pid);
    // //多多客获取爆款排行商品接口
    // await this.$pdd.pddrequest({
    //   type: "pdd.ddk.top.goods.list.query",
    //   p_id: pdd_pid,
    //   sort_type:1,
    //   offset:0,
    //   limit:400,
    // });
    // 多多客生成单品推广小程序二维码url
    // await this.$pdd.pddrequest({
    //   type: "pdd.ddk.weapp.qrcode.url.gen",
    //   p_id: pdd_pid.p_id_generate_response.p_id_list[0].p_id,
    //   goods_id_list:[23343080877,],
    //   custom_parameters:'123'
    // });
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.interval10 {
  height: 10px;
}
#grid {
  background: #fff;
}
#bar-fixed {
  position: fixed;
  width: 100%;
  z-index: 999;
}
/* tab-item选中时的样式 */
.tab-active {
  font-weight: bold;
}
/* tab-item的宽度，决定一行显示几个tab */
.scrollable .vux-tab-item {
  -webkit-flex: 0 0 15%;
  flex: 0 0 15%;
}
</style>
