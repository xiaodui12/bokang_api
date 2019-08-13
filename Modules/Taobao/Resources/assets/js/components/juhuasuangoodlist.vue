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
        @click="seeDetail(item)"
      >
        <div class="gooditem-image">
          <img :src="item.img" alt />
        </div>
        <div class="gooditem-desc">
          <div class="gooditem-name">
            <div class="gooditem-name-text">{{item.title}}</div>
            <!-- <div
              class="gooditem-name-icon iconfont icon-qiandai1"
              :class="item.coupon_amount>0?'':'icon-grey'"
            ></div>-->
          </div>
          <div class="gooditem-remark">
            <div class="gooditem-oriprice">
              <span class="gooditem-oriprice-icon iconfont icon-taobao"></span>
              <span class="gooditem-oriprice-num">￥{{item.orig_price}}</span>
            </div>
            <div class="gooditem-sale">
              <!-- <span class="gooditem-sale-desc">销量：</span> -->
              <span class="gooditem-sale-num">{{item.price_usp_list.string[0]}}</span>
            </div>
          </div>
          <div class="gooditem-main">
            <div class="gooditem-nowprice">
              <span class="gooditem-nowprice-desc">现价：</span>
              <span class="gooditem-nowprice-num">{{item.act_price}}</span>
            </div>
            <div class="gooditem-ticket" v-if="item.coupon_amount>0">
              <span class="gooditem-ticket-desc">券</span>
              <span class="gooditem-ticket-num">￥{{item.coupon_amount}}</span>
            </div>
          </div>
          <!-- <div class="gooditem-mall">
            <span class="gooditem-mall-icon iconfont icon-business-1"></span>
            <span class="gooditem-mallname">{{item.shop_title}}</span>
          </div>-->
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
        var img = item.pic_url_for_p_c;
        return {
          ...item,
          img
        };
      });
    }
  },
  data() {
    return {};
  },
  methods: {
    seeDetail(item) {
      this.$router.push({
        path: "/taobao/taobao_detail",
        query: {
          goods_id: item.item_id, //向详情页传递good_id
          //   coupon_id: item.coupon_id //向详情页传递coupon_id
          url: item.wap_url //向详情页传递url
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
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 100%;
        overflow: hidden;
        img {
          width: 100%;
          position: absolute;
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
          justify-content: space-between;
          .gooditem-name-text {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
          }
          .gooditem-name-icon {
            color: #f1a33a;
          }
          .icon-grey {
            color: #999;
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
              color: #FF6600;
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
          height: 24px;
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
