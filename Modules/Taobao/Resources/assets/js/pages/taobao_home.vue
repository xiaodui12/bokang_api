<template>
  <div class="pdd_home">
    <!-- 顶部固定导航栏 -->
    <div id="bar-fixed">
      <!-- 搜索 -->
      <search position="absolute" :auto-fixed="false" @on-focus="search" ref="search"></search>
    </div>
    <div :style="'height:' + barHeight + 'px'"></div>
    <goodlist :goodList="goodList" :isTitle="false"></goodlist>
    <div class="goodlist-showmore" @click="taobaoJuItemsSearch()">
      <span>点击加载更多</span>
    </div>
  </div>
</template>

<script>
//部分引入vux组件
import { Search, Grid, GridItem, Tab, TabItem, Swiper } from "vux";
//引入商品列表组件
import goodlist from "@/components/juhuasuangoodlist";
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
  computed: {},
  data() {
    return {
      page: 1,
      goodList: [],
      barHeight: 0
    };
  },
  methods: {
    //点击跳转搜索页面
    search() {
      this.$router.push({ path: "/taobao/taobao_search" });
    },
    //页面滚动
    // onScroll() {
    //   //页面滚动触底
    //   let innerHeight = document.querySelector("#app").clientHeight; // 可滚动容器的高度
    //   let outerHeight = document.documentElement.clientHeight; // 屏幕尺寸高度
    //   let scrollTop = document.documentElement.scrollTop; // 可滚动容器超出当前窗口显示范围的高度
    //   if (outerHeight + scrollTop == innerHeight) {
    //     // 加载更多操作
    //     this.taobaoJuItemsSearch();
    //   }
    // },
    //淘宝客商品列表查询
    async taobaoJuItemsSearch() {
      this.$vux.loading.show({
        text: "正在努力加载..."
      });
      var obj = {
        pid: this.$store.state.pid,
        page_size: 20,
        current_page: this.page
      };
      var res = await this.$request.taobao({
        param_top_item_query: JSON.stringify(obj),
        method: "taobao.ju.items.search"
      });
      this.goodList = this.goodList.concat(
        res.data.ju_items_search_response.result.model_list.items
      );
      this.page = this.page + 1; //成功获取商品列表后，页码加一
      this.$vux.loading.hide();
    }
  },
  async created() {
    // 监听滚动事件
    // window.addEventListener("scroll", this.onScroll);
  },
  async mounted() {
    //获取顶部搜索栏和导航栏高度
    this.barHeight = document.querySelector("#bar-fixed").clientHeight;
    this.taobaoJuItemsSearch();
    this.$vux.toast.show({
      type: "text",
      text: "聚划算商品，没有优惠券哦~"
    });
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
.goodlist-showmore {
  height: 40px;
  line-height: 40px;
  color: #999;
  font-size: 12px;
}
</style>
