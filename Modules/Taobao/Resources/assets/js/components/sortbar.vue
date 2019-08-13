<template>
  <div class="sortbar">
    <div
      v-for="(item,index) in config"
      :key="index"
      class="sortbar-item"
      @click="sortbarClick(index,item)"
    >
      <span
        class="sortbar-name"
        :class="item.className == 'with_coupon' && selected.with_coupon ||selected.sortSelected == item.value?'name-active':''"
      >{{item.name}}</span>
      <img v-if="item.type == 1&& selected.sortSelected != item.value" class="sortbar-icon" src="@/assets/up_down.png" alt="">
      <img v-if="item.type == 1&& selected.sortSelected == item.value && item.choose %2 == 0" class="sortbar-icon" src="@/assets/up.png" alt="">
      <img v-if="item.type == 1&& selected.sortSelected == item.value && item.choose %2 == 1" class="sortbar-icon" src="@/assets/down.png" alt="">
      <!-- <span
        class="sortbar-icon iconfont"
        v-if="item.type == 1"
        :class="item.choose %2 == 1 ?'icon-jiang':'icon-sheng'"
      ></span> -->
    </div>
  </div>
</template>

<script>
export default {
  name: "goodlist",
  props: {
    config: {
      type: Array,
      default: null
    },
    selected: {
      type: Object,
      default: null
    }
  },
  components: {},
  computed: {},
  data() {
    return {};
  },
  methods: {
    sortbarClick(index, value) {
      value = {
        ...value,
        index
      };
      if (this.selected.sortSelected != value.value || value.type == 1) {
        if (value.className == "sort") {
          this.$emit("sortType", value);
        } else if (value.className == "with_coupon") {
          this.$emit("couponType", value);
        }
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
.sortbar {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-around;
  background-color: #fff;
  height: 40px;
  .sortbar-item {
    border-right: 0.5px solid #eee;
    flex: 1;
    height: 40px;
    line-height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    .sortbar-name {
      font-size: 14px;
    }
    .name-active {
      color: #a8d081;
    }
    .sortbar-icon{
      width: 16px;
      height: 16px;
      display: inline-block;
    }
  }
  .sortbar-item:last-child {
    border-right: none;
  }
}
</style>
