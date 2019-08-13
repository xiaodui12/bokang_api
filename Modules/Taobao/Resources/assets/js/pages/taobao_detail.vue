<template>
  <div class="pdd_search">
    <!-- 轮播图 -->
    <swiper
      :list="swiperList"
      :show-dots="false"
      :show-desc-mask="false"
      loop
      :height="swiperHeight"
    ></swiper>
    <!-- 商品描述 -->
    <div class="goodDetail-goodinfo">
      <div class="goodDetai-nowprice">
        <div class="nowprice">
          <span class="desc">折扣价￥</span>
          <span class="num">{{good.zk_final_price}}</span>
        </div>
        <div class="sale">
          <span></span>
          <span>{{good.provcity}}</span>
        </div>
      </div>
      <div class="goodDetail-oriprice">
        <div class="oriprice">
          <span>原价￥</span>
          <span>{{good.reserve_price}}</span>
        </div>
      </div>
      <div class="goodDetail-name">
        <span class="iconfont icon-taobao icon"></span>
        <span class="name">{{good.title}}</span>
      </div>
      <div class="goodDetail-ticket" v-if="good.coupon_amount">
        <img src="@/assets/coupon_ticket.png" class="ticket-img" />
        <div class="ticket-info">
          <div class="ticket-price">
            <span class="remark">￥</span>
            <span class="main">{{good.coupon_amount}}</span>
            <span class="remark">优惠券</span>
          </div>
          <div class="ticket-time">
            <span>仅限</span>
            <span>{{good.coupon_start_time_format}}</span>
            <span>~</span>
            <span>{{good.coupon_end_time_format}}</span>
            <span>剩余</span>
            <span>{{good.coupon_remain_count}}</span>
            <span>张</span>
          </div>
        </div>
        <div class="ticket-get">
          <div class="get-button">立即领取</div>
        </div>
      </div>
      <!-- <div class="goodDetail-remark">
        <span>全场包邮 7天退换 48小时发货 假一赔十</span>
      </div>-->
    </div>
    <!-- 店铺描述 -->
    <!-- <div class="goodDetail-mallinfo">
      <div class="goodDetaill-mallname">
        <div class="mall-info">
          <div class="mall-logo">
            <x-img :src="mallDetail.img_url"></x-img>
          </div>
          <span class="mall-name">{{mallDetail.nick}}</span>
        </div>
        <div class="mall-btn">
          <span class="btn-text">进入店铺</span>
          <span class="iconfont icon-back-copy icon"></span>
        </div>
      </div>
      <div class="goodDetail-mallevaluate">
        <div class="mallevaluate-item">
          <div class="evaluate-desc">宝贝描述</div>
          <div
            class="evaluate-level"
            :class=" mallDetail.desc_txt =='低'?'rank-green':''"
          >{{mallDetail.desc_txt}}</div>
        </div>
        <div class="mallevaluate-item">
          <div class="evaluate-desc">卖家服务</div>
          <div
            class="evaluate-level"
            :class=" mallDetail.lgst_txt =='低'?'rank-green':''"
          >{{mallDetail.lgst_txt}}</div>
        </div>
        <div class="mallevaluate-item">
          <div class="evaluate-desc">物流服务</div>
          <div
            class="evaluate-level"
            :class=" mallDetail.serv_txt =='低'?'rank-green':''"
          >{{mallDetail.serv_txt}}</div>
        </div>
      </div>
    </div>-->
    <!-- 商品描述、商品图文详情 -->
    <!-- <div class="goodDetail-desc">
      <span class="desc">商品描述：</span>
      <span class="content">{{goodDetail.goods_desc}}</span>
    </div>-->
    <div class="goodDetail-image-group">
      <x-img v-for="(item,index) in swiperList" :key="index" :src="item.img" />
    </div>
    <!-- 操作栏 -->
    <div style="margin-bottom: 55px;"></div>
    <div class="operation-bar">
      <div class="operation-wrap">
        <div class="operation-button left-type">分享好友</div>
        <div
          class="operation-button right-type"
          v-clipboard:copy="tpwd"
          @click="buy()"
        >领券购买</div>
      </div>
    </div>
  </div>
</template>

<script>
import { Swiper, XImg } from "vux";
import dayjs from "dayjs";

export default {
  name: "pdd_detail",
  components: {
    Swiper,
    XImg
  },
  computed: {
    swiperList() {
      return this.img_arr.map(item => {
        var url = null;
        var img = item;
        var title = null;
        return {
          url,
          img,
          title
        };
      });
    },
    good() {
      var goodDetail = this.goodDetail;
      var ticketDetail = this.ticketDetail;
      var coupon_start_time_format = dayjs(
        ticketDetail.coupon_start_time
      ).format("MM.DD");
      var coupon_end_time_format = dayjs(ticketDetail.coupon_end_time).format(
        "MM.DD"
      );
      var coupon_amount = ticketDetail.coupon_amount;
      var coupon_remain_count = ticketDetail.coupon_remain_count;
      return {
        ...goodDetail,
        coupon_start_time_format,
        coupon_end_time_format,
        coupon_amount,
        coupon_remain_count
      };
    }
  },
  data() {
    return {
      goodDetail: {},
      ticketDetail: {},
      mallDetail: {},
      img_arr: [],
      swiperHeight: "0px",
      tpwd: null
    };
  },
  created() {},
  mounted() {
    this.getParams();
    this.swiperHeight = document.querySelector("#app").clientWidth + "px";
  },
  watch: {
    $route: "getParams"
  },
  methods: {
    //从router中获取goods_id
    getParams() {
      this.taobaoTbkItemInfoGet(this.$route.query.goods_id);
      this.taobaoTbkTpwdCreate();
      if (this.$route.query.coupon_id) {
        this.taobaoTbkCouponGet(
          this.$route.query.goods_id,
          this.$route.query.coupon_id
        );
      }
    },
    //淘宝客商品列表查询
    async taobaoTbkItemInfoGet(goods_id) {
      var res = await this.$request.taobao({
        num_iids: goods_id,
        adzone_id: this.$store.state.adzone_id,
        method: "taobao.tbk.item.info.get"
      });
      this.goodDetail =
        res.data.tbk_item_info_get_response.results.n_tbk_item[0];
      var pict_url = [
        res.data.tbk_item_info_get_response.results.n_tbk_item[0].pict_url
      ];
      this.img_arr = pict_url.concat(
        res.data.tbk_item_info_get_response.results.n_tbk_item[0].small_images
          .string
      );
    },
    //淘宝客优惠券详情查询
    async taobaoTbkCouponGet(goods_id, coupon_id) {
      var res = await this.$request.taobao({
        item_id: goods_id,
        activity_id: coupon_id,
        adzone_id: this.$store.state.adzone_id,
        method: "taobao.tbk.coupon.get"
      });
      this.ticketDetail = res.data.tbk_coupon_get_response.data;
    },
    //获取淘口令
    async taobaoTbkTpwdCreate() {
      var res = await this.$request.taobao({
        method: "taobao.tbk.tpwd.create",
        text: "可编辑的淘口令文字",
        url: this.$route.query.url
      });
      this.tpwd = res.data.tbk_tpwd_create_response.data.model;
    },
    //点击事件
    buy() {
      this.$vux.alert.show({
        title: "复制成功",
        content: "我们已为您准备好淘口令，您只需打开淘宝，即可领取优惠券！"
      });
    },
    //错误提示
    error(msg) {
      this.$vux.toast.show({
        type: "error",
        text: msg
      });
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
.goodDetail-goodinfo {
  width: 100%;
  background-color: #fff;
  padding: 0.5rem 0;
  margin: 0.2rem 0;
  .goodDetai-nowprice {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 0.5rem;
    height: 35px;
    .nowprice {
      color: #ed2c21;
      .desc {
        font-size: 14px;
      }
      .num {
        font-size: 20px;
      }
    }
    .sale {
      color: #999;
      font-size: 12px;
    }
  }
  .goodDetail-oriprice {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 0.5rem;
    height: 35px;
    .oriprice {
      font-size: 12px;
      color: #999;
      text-decoration: line-through;
    }
  }
  .goodDetail-name {
    padding: 0.5rem;
    text-align: left;
    line-height: 20px;
    .icon {
      font-size: 18px;
      margin-right: 5px;
      color: #FF6600;
    }
    .name {
      font-size: 14px;
    }
  }
  .goodDetail-ticket {
    padding: 0.5rem;
    width: 100%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    .ticket-img {
      width: 100%;
      height: 100%;
    }
    .ticket-info {
      position: absolute;
      z-index: 1;
      left: 6%;
      width: 55%;
      .ticket-price {
        .remark {
          font-size: 12px;
          color: #fff;
        }
        .main {
          font-size: 30px;
          color: #fff;
          font-weight: bold;
        }
      }
      .ticket-time {
        font-size: 11px;
        color: #ffeb3e;
      }
    }
    .ticket-get {
      position: absolute;
      z-index: 1;
      right: 6%;
      width: 30%;
      .get-button {
        width: 80%;
        height: 30px;
        border-radius: 15px;
        margin: 0 auto;
        font-size: 15px;
        color: #f43218;
        background-color: #ffeb3e;
        line-height: 30px;
        font-weight: bold;
      }
    }
  }
  .goodDetail-remark {
    text-align: center;
    font-size: 12px;
    color: #999;
  }
}
.goodDetail-mallinfo {
  margin-top: 5px;
  background-color: #fff;
  .goodDetaill-mallname {
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 0.5rem;
    .mall-info {
      display: inline-flex;
      align-items: center;
      .mall-logo {
        width: 30px;
        height: 30px;
        border-radius: 5px;
        overflow: hidden;
        margin-right: 10px;
      }
      .mall-name {
        font-size: 12px;
      }
    }
    .mall-btn {
      display: inline-flex;
      align-items: center;
      .btn-text {
        font-size: 12px;
        color: #999;
      }
      .icon {
        font-size: 12px;
        color: #999;
        margin-left: 5px;
      }
    }
  }
  .goodDetail-mallevaluate {
    display: flex;
    align-items: center;
    justify-content: space-around;
    height: 40px;
    .mallevaluate-item {
      display: inline-flex;
      .evaluate-desc {
        font-size: 12px;
        color: #999;
        margin-right: 10px;
      }
      .evaluate-level {
        font-size: 12px;
        background-color: #f43218;
        color: #fff;
        width: 16px;
        height: 16px;
        line-height: 16px;
      }
      .rank-green {
        background-color: rgb(27, 179, 27);
      }
    }
  }
}
.goodDetail-desc {
  padding: 0.3rem 0.5rem;
  margin-top: 5px;
  background-color: #fff;
  text-align: left;
  font-size: 13px;
  color: #999;
  margin-bottom: 10rpx;
}
.goodDetail-image-group {
  width: 100%;
  img {
    width: 100%;
  }
}
.operation-bar {
  height: 50px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  bottom: 0;
  background-color: #fff;
  z-index: 999;
  box-shadow: 0 0.5px 3px rgba(0, 0, 0, 0.1);
  .operation-wrap {
    display: flex;
    width: calc(100% - 8rem);
    height: 36px;
    align-items: center;
    .operation-button {
      flex: 1;
      font-size: 15px;
      height: 100%;
      box-sizing: border-box;
      line-height: 36px;
    }

    .left-type {
      color: #e60012;
      border: 1px solid #e60012;
      background-color: #fff;
      border-radius: 0 !important;
      padding: 0 !important;
      border-top-left-radius: 18px !important;
      border-bottom-left-radius: 18px !important;
    }

    .right-type {
      color: #fff;
      background-color: #e60012;
      border-top-right-radius: 18px;
      border-bottom-right-radius: 18px;
    }
  }
}
</style>
