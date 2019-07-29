<template>
    <div class="header" v-if="title">
        <div class="back" @click="back" v-if="showLeft"><img src="/images/cag/back.png"></div>
        <div class="title" :style="headerStyle">{{title}}</div>
<!--        <div class="home" @click="home" v-if="showRight"></div>-->
    </div>
</template>
<script>
    export default {
        name: 'ljqzHeader',
        props: {
            title: {
                type: String,
                default: ''
            },
            showLeft: {
                type: Boolean,
                default: true
            },
            showRight: {
                type: Boolean,
                default: true
            },
            align: {
                type: String,
                default: 'center'
            }
        },
        computed: {
            headerStyle() {
                return {
                    'text-align': this.align,
                }
            }
        },
        methods: {
            back() {
                this.$router.back();
            },
            home() {
                this.$router.push('/')
            }
        }
    }
</script>
<style lang="scss" scoped>
    .header {
        position: relative;
        width: 100%;
        height: rpx(100px);
        line-height: rpx(100px);
        background: #fff;
        padding:0 $paddingLeftRight;
        box-sizing: border-box;
        border-bottom: rpx(3px) solid rgba(243, 243, 243, 1);
        .back {
            z-index: 999;
            display: inline-block;
            height: rpx(34px);
            width: rpx(18px);
            position: absolute;
            top: calc(50% - 0.22667rem);
            img {
                width: 100%;
                height: 100%;
                vertical-align: top;
            }
        }
        .title {
            display: inline-block;
            position: absolute;
            font-size: rpx(36px);
            box-sizing: border-box;
            left: rpx($paddingLeftRight + 45px);
            right: rpx($paddingLeftRight + 45px);
            z-index: 0;
        }
        .home {
            z-index: 999;
            display: inline-block;
            float: right;
            &::after {
                content: ' ';
                background: url("/images/ljqz/home.png");
                background-size: 100% 100%;
                width: rpx(15px);
                height: rpx(15px);
                padding-left: rpx(24px);
                padding-top: rpx(4px);
            }
        }
    }
</style>
