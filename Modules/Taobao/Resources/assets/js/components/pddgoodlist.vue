<template>
  <div class="goodlist">
    <div class="goodlist-title" v-if="isTitle">
      <span class="goodlist-title-text">商品推荐</span>
      <img class="goodlist-title-image" src="@/assets/title-tag.png" alt />
    </div>
    <div class="goodlist-wrap">
      <div
        class="gooditem-wrap"
        v-for="(item,index) in goodListFormat"
        :key="index"
        @click="seeDetail(item.goods_id)"
      >
        <div class="gooditem-image">
          <img :src="item.goods_thumbnail_url" alt />
        </div>
        <div class="gooditem-desc">
          <div class="gooditem-name">
            <div class="gooditem-name-text">{{item.goods_name}}</div>
            <div class="gooditem-name-icon iconfont icon-qiandai1"></div>
          </div>
          <div class="gooditem-remark">
            <div class="gooditem-oriprice">
              <span class="gooditem-oriprice-icon iconfont icon-pinduoduodingdan"></span>
              <span class="gooditem-oriprice-num">￥{{item.min_group_price}}</span>
            </div>
            <div class="gooditem-sale">
              <span class="gooditem-sale-desc">销量：</span>
              <span class="gooditem-sale-num">{{item.sales_tip}}</span>
            </div>
          </div>
          <div class="gooditem-main">
            <div class="gooditem-nowprice">
              <span class="gooditem-nowprice-desc">券后：</span>
              <span class="gooditem-nowprice-num">{{item.after_coupon_discount}}</span>
            </div>
            <div class="gooditem-ticket" v-if="item.coupon_discount > 0">
              <span class="gooditem-ticket-desc">券</span>
              <span class="gooditem-ticket-num">￥{{item.coupon_discount}}</span>
            </div>
          </div>
          <div class="gooditem-mall">
            <span class="gooditem-mall-icon iconfont icon-business-1"></span>
            <span class="gooditem-mallname">{{item.mall_name}}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "goodlist",
  props: {
    goodList: {
      type: Array,
      default: null
    },
    isTitle: {
      type: [Boolean, String],
      default: true
    }
  },
  components: {},
  computed: {
    // 计算属性，过滤当前列表数据，金额从分转成元，获取券后价格
    goodListFormat() {
      return this.goodList.map(item => {
        var min_group_price = item.min_group_price / 100;
        var coupon_discount = item.coupon_discount / 100;
        var after_coupon_discount = (min_group_price - coupon_discount).toFixed(
          2
        );
        return {
          ...item,
          min_group_price,
          coupon_discount,
          after_coupon_discount
        };
      });
    }
  },
  data() {
    return {};
  },
  methods: {
    seeDetail(goods_id) {
      this.$router.push({
        path: "/pdd/pdd_detail",
        query: {
          goods_id,//向详情页传递good_id
        }
      });
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
.goodlist {
  background-color: #f2f2f2;
  .goodlist-title {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 50px;
    color: red;
    background-color: #fff;
    position: relative;
    .goodlist-title-text {
      font-size: 14px;
    }
    .goodlist-title-image {
      position: absolute;
      width: 100%;
      height: 100%;
    }
  }
  .goodlist-wrap {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin: 0 0.5rem;
    .gooditem-wrap {
      width: 49%;
      background-color: #fff;
      margin-top: 0.5rem;
      border-radius: 0.5rem;
      overflow: hidden;
      .gooditem-image {
        width: 100%;
        img {
          width: 100%;
          height: 100%;
        }
      }
      .gooditem-desc {
        width: 100%;
        padding: 0 0.2rem;
        .gooditem-name {
          font-size: 15px;
          height: 20px;
          line-height: 20px;
          display: flex;
          .gooditem-name-text {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
          }
          .gooditem-name-icon {
            color: #f1a33a;
          }
        }
        .gooditem-remark {
          height: 20px;
          line-height: 20px;
          display: flex;
          align-items: center;
          justify-content: space-between;
          .gooditem-oriprice {
            font-size: 12px;
            .gooditem-oriprice-icon {
              color: red;
            }
            .gooditem-oriprice-num {
              color: #999;
            }
          }
          .gooditem-sale {
            color: #999;
            font-size: 12px;
            .gooditem-sale-desc {
            }
            .gooditem-sale-num {
            }
          }
        }
        .gooditem-main {
          height: 24px;
          line-height: 24px;
          width: 100%;
          display: inline-flex;
          align-items: center;
          justify-content: space-between;
          .gooditem-nowprice {
            color: #ec6964;
            .gooditem-nowprice-desc {
              font-size: 12px;
            }
            .gooditem-nowprice-num {
              font-size: 18px;
              font-weight: bold;
            }
          }
          .gooditem-ticket {
            background-color: #fcefd3;
            display: inline-flex;
            align-items: center;
            border-radius: 5px;
            height: 16px;
            .gooditem-ticket-desc {
              background-color: #e7a63e;
              width: 16px;
              height: 16px;
              border-radius: 5px;
              font-size: 10px;
              color: #fff;
              line-height: 16px;
            }
            .gooditem-ticket-num {
              width: 30px;
              color: #955724;
              font-size: 12px;
              font-weight: bold;
            }
          }
        }
        .gooditem-mall {
          height: 20px;
          line-height: 20px;
          border-top: 0.5px solid #eee;
          text-align: left;
          text-overflow: ellipsis;
          white-space: nowrap;
          overflow: hidden;
          .gooditem-mall-icon {
            color: #ec6964;
          }
          .gooditem-mallname {
            font-size: 12px;
            color: #999;
          }
        }
      }
    }
  }
}
</style>
