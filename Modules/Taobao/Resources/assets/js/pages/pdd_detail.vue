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
          <span class="desc">券后￥</span>
          <span class="num">{{good.after_coupon_discount}}</span>
        </div>
        <div class="sale">
          <span>销量：</span>
          <span>{{good.sales_tip}}</span>
        </div>
      </div>
      <div class="goodDetail-oriprice">
        <div class="oriprice">
          <span>原价￥</span>
          <span>{{good.min_group_price}}</span>
        </div>
      </div>
      <div class="goodDetail-name">
        <span class="iconfont icon-pinduoduodingdan icon"></span>
        <span class="name">{{good.goods_name}}</span>
      </div>
      <div class="goodDetail-ticket">
        <img src="@/assets/coupon_ticket.png" class="ticket-img" />
        <div class="ticket-info">
          <div class="ticket-price">
            <span class="remark">￥</span>
            <span class="main">{{good.coupon_discount}}</span>
            <span class="remark">优惠券</span>
          </div>
          <div class="ticket-time">
            <span>仅限</span>
            <span>{{good.coupon_start_time_format}}</span>
            <span>~</span>
            <span>{{good.coupon_end_time_format}}</span>
            <span>剩余</span>
            <span>{{good.coupon_total_quantity}}</span>
            <span>张</span>
          </div>
        </div>
        <div class="ticket-get">
          <div class="get-button">立即领取</div>
        </div>
      </div>
      <div class="goodDetail-remark">
        <span>全场包邮 7天退换 48小时发货 假一赔十</span>
      </div>
    </div>
    <!-- 店铺描述 -->
    <!-- <div class="goodDetail-mallinfo">
      <div class="goodDetaill-mallname">
        <div class="mall-info">
          <div class="mall-logo">
            <x-img :src="mallDetail.img_url"></x-img>
          </div>
          <span class="mall-name">{{mallDetail.mall_name}}</span>
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
    <div class="goodDetail-desc">
      <span class="desc">商品描述：</span>
      <span class="content">{{goodDetail.goods_desc}}</span>
    </div>
    <div class="goodDetail-image-group">
      <x-img v-for="(item,index) in swiperList" :key="index" :src="item.img" />
    </div>
    <!-- 操作栏 -->
    <div style="margin-bottom: 55px;"></div>
    <div class="operation-bar">
      <div class="operation-wrap">
        <div class="operation-button left-type">分享好友</div>
        <div class="operation-button right-type" @click="buy()">领券购买</div>
      </div>
    </div>
    <!-- 弹出层 -->
    <x-dialog v-model="showHideOnBlur" class="dialog-demo" hide-on-blur>
      <div class="img-box">
        <img :src="Qrcode" style="max-width:100%" />
        <button>保存图片</button>
      </div>
      <div @click="showHideOnBlur=false">
        <span class="vux-close"></span>
      </div>
    </x-dialog>
  </div>
</template>

<script>
import { Swiper, XImg, XDialog } from "vux";
import dayjs from "dayjs";

export default {
  name: "pdd_detail",
  components: {
    Swiper,
    XImg,
    XDialog
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
      var min_group_price = goodDetail.min_group_price / 100;
      var coupon_discount = goodDetail.coupon_discount / 100;
      var after_coupon_discount = (min_group_price - coupon_discount).toFixed(
        2
      );
      var coupon_start_time_format = dayjs(
        goodDetail.coupon_start_time * 1000
      ).format("MM.DD");
      var coupon_end_time_format = dayjs(
        goodDetail.coupon_end_time * 1000
      ).format("MM.DD");
      return {
        ...goodDetail,
        coupon_start_time_format, //格式化优惠券开始时间
        coupon_end_time_format, //格式化优惠券结束时间
        min_group_price, //最小成团加（原价）
        coupon_discount, //优惠券价格
        after_coupon_discount //最低现价（原价-优惠券）
      };
    }
  },
  data() {
    return {
      goodDetail: {},
      mallDetail: {},
      img_arr: [],
      showHideOnBlur: false,
      Qrcode: null,
      swiperHeight: "0px"
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
      console.log(this.$store.state)
      this.pddDdkGoodsDetail(this.$route.query.goods_id);
      this.pddDdkWeappQrcodeUrlGen(this.$route.query.goods_id);
    },
    //多多进宝商品详情查询
    async pddDdkGoodsDetail(goods_id) {
      var res = await this.$pdd.pddrequest({
        type: "pdd.ddk.goods.detail",
        goods_id_list: "[" + goods_id + "]"
      });
      this.goodDetail = res.goods_detail_response.goods_details[0];
      this.img_arr =
        res.goods_detail_response.goods_details[0].goods_gallery_urls;
      this.pddDdkMerchantListGet(this.goodDetail.mall_id);
    },
    //多多进宝店铺详情查询
    async pddDdkMerchantListGet(mall_id) {
      var res = await this.$pdd.pddrequest({
        type: "pdd.ddk.merchant.list.get",
        mall_id_list: "[" + mall_id + "]"
      });
      this.mallDetail = res.merchant_list_response.mall_search_info_vo_list[0];
    },
    //多多进宝生成单品推广小程序二维码
    async pddDdkWeappQrcodeUrlGen(goods_id) {
      var res = await this.$pdd.pddrequest({
        type: "pdd.ddk.weapp.qrcode.url.gen",
        p_id: this.$store.state.pdd_GZH_pid,
        goods_id_list: "[" + goods_id + "]"
      });
      this.url = res;
    },
    //领券购买
    buy() {
      this.showHideOnBlur = true;
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
      color: #fa0015;
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
  z-index: 999;
  background-color: #fff;
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
