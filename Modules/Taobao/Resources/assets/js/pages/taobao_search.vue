<template>
  <div class="pdd_search">
    <div id="bar-fixed">
      <search
        position="absolute"
        @result-click="b"
        @on-change="b"
        v-model="keyword"
        :auto-fixed="false"
        @on-focus="b"
        @on-cancel="b"
        @on-submit="search"
      ></search>
      <sortbar
        :config="sortbar"
        :selected="sortSelected"
        v-on:sortType="changesort"
        v-on:couponType="changecoupon"
      ></sortbar>
    </div>
    <div :style="'height:' + barHeight + 'px'"></div>
    <goodlist :goodList="goodList" :isTitle="false"></goodlist>
    <div class="goodlist-showmore" @click="loadmore()">
      <span>点击加载更多</span>
    </div>
  </div>
</template>

<script>
import { Search, Grid, GridItem } from "vux";
import goodlist from "@/components/taobaogoodlist";
import sortbar from "@/components/sortbar";

export default {
  name: "pdd_search",
  components: {
    Search,
    Grid,
    GridItem,
    goodlist,
    sortbar
  },
  computed: {},

  data() {
    return {
      keyword: null,
      barHeight: null,
      goodList: [],
      sortSelected: {
        sortSelected: 0,
        sort_type: "tk_total_sales_des",
        with_coupon: false
      },
      sortbar: [
        {
          name: "综合",
          type: 0,
          className: "sort",
          value: 0,
          sort_id: "tk_total_sales_des"
        },
        {
          name: "销量",
          type: 1,
          className: "sort",
          value: 1,
          choose: 0,
          sort_id: ["total_sales_asc", "total_sales_des"]
        },
        {
          name: "价格",
          type: 1,
          className: "sort",
          value: 2,
          choose: 0,
          sort_id: ["price_asc", "price_des"]
        },
        {
          name: "优惠券",
          type: 0,
          className: "with_coupon",
          value: 3
        }
      ],
      page: 1
    };
  },
  methods: {
    search(value) {
      this.keyword = value;
      (this.page = 1), (this.goodList = []);
      this.taobaoTbkDgMaterialOptional({
        q: this.keyword,
        sort: this.sortSelected.sort_type,
        has_coupon: this.sortSelected.has_coupon
      });
    },
    b() {},
    //更改排序
    changesort(value) {
      if (!this.keyword) {
        this.$vux.toast.show({
          type: "text",
          text: "请输入您要搜索的商品名"
        });
      } else {
        this.sortSelected.sortSelected = value.value; //切换选择
        (this.page = 1), (this.goodList = []);
        if (value.type == 1) {
          this.sortbar[value.index].choose = value.choose + 1;
          this.sortSelected.sort_type =
            value.sort_id[this.sortbar[value.index].choose % 2];
        } else {
          this.sortSelected.sort_type = value.sort_id;
        }
        this.taobaoTbkDgMaterialOptional({
          q: this.keyword,
          sort: this.sortSelected.sort_type,
          has_coupon: this.sortSelected.with_coupon
        });
      }
    },
    //更改是否显示优惠券
    changecoupon(value) {
      this.sortSelected.with_coupon = !this.sortSelected.with_coupon;
      (this.page = 1), (this.goodList = []);
      this.taobaoTbkDgMaterialOptional({
        q: this.keyword,
        sort: this.sortSelected.sort_type,
        has_coupon: this.sortSelected.with_coupon
      });
    },
    //页面滚动
    // onScroll() {
    //   //页面滚动触底
    //   let innerHeight = document.querySelector("#app").clientHeight; // 可滚动容器的高度
    //   let outerHeight = document.documentElement.clientHeight; // 屏幕尺寸高度
    //   let scrollTop = document.documentElement.scrollTop; // 可滚动容器超出当前窗口显示范围的高度
    //   if (outerHeight + scrollTop == innerHeight) {
    //     // 加载更多操作
    //     this.taobaoTbkDgMaterialOptional({
    //       q: this.keyword,
    //       sort: this.sortSelected.sort_type,
    //       has_coupon: this.sortSelected.has_coupon
    //     });
    //   }
    // },
    //加载更多
    loadmore() {
      this.taobaoTbkDgMaterialOptional({
        q: this.keyword,
        sort: this.sortSelected.sort_type,
        has_coupon: this.sortSelected.has_coupon
      });
    },
    //淘宝客商品列表查询
    async taobaoTbkDgMaterialOptional(obj) {
      this.$vux.loading.show({
        text: "正在努力加载..."
      });

      var res = await this.$request.taobao({
        ...obj,
        adzone_id: this.$store.state.adzone_id,
        method: "taobao.tbk.dg.material.optional",
        page_size: 20,
        page_no: this.page
      });
      this.goodList = this.goodList.concat(
        res.data.tbk_dg_material_optional_response.result_list.map_data
      );
      this.page = this.page + 1; //成功获取商品列表后，页码加一
      this.$vux.loading.hide();
    }
  },
  async created() {
    // 监听滚动事件
    window.addEventListener("scroll", this.onScroll);
  },
  async mounted() {
    //获取顶部搜索栏和导航栏高度
    // this.barHeight = document.querySelector("#bar-fixed").clientHeight;
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
#bar-fixed {
  position: fixed;
  width: 100%;
  z-index: 999;
}
.goodlist-showmore {
  height: 40px;
  line-height: 40px;
  color: #999;
  font-size: 12px;
}
</style>
