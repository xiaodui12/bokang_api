<template>
  <section class="box">
    <div class="content">
      <div class="left" ref="left">
        <ul>
          <li
          class="left-item"
            v-for="(item, index) in optList"
            :key="index"
            :class="currentIndex == index?'left-active':''"
            @click="selectItem(index, $event)"
          >
            <span>{{item.opt_name}}</span>
          </li>
        </ul>
      </div>
      <div class="right" ref="right">
        <ul>
          <li class="right-item right-item-hook" v-for="item in optList" :key="item.opt_name">
            <div>{{item.opt_name}}</div>
            <div style="width:100%;background:#fff;">
                <div  v-for="index in 5" :key="index" style="width:30%;height:100px;">
                    {{item.opt_name + index}}
                </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>
<script>
import BScroll from "better-scroll";
export default {
  data() {
    return {
      left: ["a", "b", "c", "d", "e", "f"],
      right: [
        {
          name: "a",
          content: ["1", "2", "3", "4", "5"]
        },
        {
          name: "b",
          content: ["1", "2", "3", "4", "5"]
        },
        {
          name: "c",
          content: ["1", "2", "3", "4", "5"]
        },
        {
          name: "d",
          content: ["1", "2", "3", "4", "5"]
        },
        {
          name: "e",
          content: ["1", "2", "3", "4", "5"]
        },
        {
          name: "f",
          content: ["1", "2", "3", "4", "5"]
        }
      ],
      listHeight: [],
      scrollY: 0, //实时获取当前y轴的高度
      clickEvent: false
    };
  },
  methods: {
    _initScroll() {
      //better-scroll的实现原理是监听了touchStart,touchend事件，所以阻止了默认的事件（preventDefault）
      //所以在这里做点击的话，需要在初始化的时候传递属性click,派发一个点击事件
      //在pc网页浏览模式下，点击事件是不会阻止的，所以可能会出现2次事件，所以为了避免2次，可以在绑定事件的时候把$event传递过去
      this.lefts = new BScroll(this.$refs.left, {
        click: true
      });
      this.rights = new BScroll(this.$refs.right, {
        probeType: 3 //探针的效果，实时获取滚动高度
      });
      //rights这个对象监听事件，实时获取位置pos.y
      this.rights.on("scroll", pos => {
        this.scrollY = Math.abs(Math.round(pos.y));
      });
    },
    _getHeight() {
      let rightItems = this.$refs.right.getElementsByClassName(
        "right-item-hook"
      );
      let height = 0;
      this.listHeight.push(height);
      for (let i = 0; i < rightItems.length; i++) {
        let item = rightItems[i];
        height += item.clientHeight;
        this.listHeight.push(height);
      }
    },
    selectItem(index, event) {
      this.clickEvent = true;
      //在better-scroll的派发事件的event和普通浏览器的点击事件event有个属性区别_constructed
      //浏览器原生点击事件没有_constructed所以当时浏览器监听到该属性的时候return掉
      if (!event._constructed) {
        return;
      } else {
        let rightItems = this.$refs.right.getElementsByClassName(
          "right-item-hook"
        );
        let el = rightItems[index];
        this.rights.scrollToElement(el, 300);
      }
    }
  },
  mounted() {
    this.$nextTick(() => {
      this._initScroll();
      this._getHeight();
    });
  },
  computed: {
    currentIndex() {
      for (let i = 0; i < this.listHeight.length; i++) {
        let height = this.listHeight[i];
        let height2 = this.listHeight[i + 1];
        //当height2不存在的时候，或者落在height和height2之间的时候，直接返回当前索引
        //>=height，是因为一开始this.scrollY=0,height=0
        if (!height2 || (this.scrollY >= height && this.scrollY < height2)) {
          return i;
        }
        if (
          this.listHeight[this.listHeight.length - 1] -
            this.$refs.right.clientHeight <=
          this.scrollY
        ) {
          if (this.clickTrue) {
            return this.currentNum;
          } else {
            return this.listHeight.length - 1;
          }
        }
      }
      //如果this.listHeight没有的话，就返回0
      return 0;
    },
    optList() {
      //精选主题
      return [
        {
          level: 1,
          opt_id: 15,
          opt_name: "百货",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 1281,
          opt_name: "鞋包",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 16,
          opt_name: "美妆",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 13,
          opt_name: "水果",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 14,
          opt_name: "女装",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 1,
          opt_name: "食品",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 4,
          opt_name: "母婴",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 743,
          opt_name: "男装",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 18,
          opt_name: "电器",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 1282,
          opt_name: "内衣",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 818,
          opt_name: "家纺",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 2478,
          opt_name: "文具",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 2048,
          opt_name: "汽车",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 1451,
          opt_name: "运动",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 1917,
          opt_name: "家装",
          parent_opt_id: 0
        },
        {
          level: 1,
          opt_id: 590,
          opt_name: "虚拟",
          parent_opt_id: 0
        }
      ];
    }
  }
};
</script>
<style scoped>
.content {
  display: flex;
  position: absolute;
  top: 0px;
  bottom: 0px;
  width: 100%;
  overflow: hidden;
  background: #eee;
}
.left {
  width: 80px;
  background-color: #f3f5f7;
}
.left li {
  width: 100%;
  height: 100%;
}
.left-item {
  display: block;
  width: 100%;
  height: 50px;
  line-height: 50px;
  text-align: center;
  font-size: 15px;
  background-color: #fff;
}
.left-active {
  color: red;
  font-weight: bold;
  background-color: #f2f2f2;
}

.right {
  flex: 1;
}
.right-item li {
  width: 100%;
  height: 100px;
  line-height: 100px;
  text-align: center;
  border-bottom: 1px solid yellow;
}
* {
  list-style: none;
  margin: 0;
  padding: 0;
}
</style>
