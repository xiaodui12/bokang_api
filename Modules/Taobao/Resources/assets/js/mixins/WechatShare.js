import wx from 'weixin-js-sdk'
import {config} from '@/api/weixin'
import {isWeiXin} from '@/utils/browser'
import wxShare from '@/utils/wxShare'

export default {
    data() {
        return {
            share_title:wxShare.shareTitle,
            share_desc:wxShare.shareDesc,
            imgUrl:wxShare.shareLogo
        }
    },
    activated(){
        if(!isWeiXin()) return false;
        this.wxConfig().then(() => {
            let that = this
            wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
                that.setImgUrl()
                that.setShareTitle()
                wx.onMenuShareTimeline({
                    title: that.share_title, // 分享标题
                    link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                    imgUrl: that.imgUrl, // 分享图标
                    success: function () {
                        // 用户点击了分享后执行的回调函数
                    },
                });

                that.setShareDesc()
                wx.onMenuShareAppMessage({
                    title: that.share_title, // 分享标题
                    desc: that.share_desc, // 分享描述
                    link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                    imgUrl: that.imgUrl, // 分享图标
                    //type: '', // 分享类型,music、video或link，不填默认为link
                    //dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                        // 用户点击了分享后执行的回调函数
                    }
                });
            });
        })
    },
    mounted() {
        if(!isWeiXin()) return false;
        this.wxConfig().then(() => {
            let that = this
            wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
                that.setImgUrl()
                that.setShareTitle()
                wx.onMenuShareTimeline({
                    title: that.share_title, // 分享标题
                    link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                    imgUrl: that.imgUrl, // 分享图标
                    success: function () {
                        // 用户点击了分享后执行的回调函数
                    },
                });

                that.setShareDesc()
                wx.onMenuShareAppMessage({
                    title: that.share_title, // 分享标题
                    desc: that.share_desc, // 分享描述
                    link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                    imgUrl: that.imgUrl, // 分享图标
                    //type: '', // 分享类型,music、video或link，不填默认为link
                    //dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                        // 用户点击了分享后执行的回调函数
                    }
                });
            });
        })
    },

    methods: {
        wxConfig(){
            return config({url : window.location.href}).then(response => {
                wx.config(JSON.parse(response.data))
            })
        },
        setShareTitle(){
            this.share_title = wxShare.shareTitle
        },
        setShareDesc(){
            this.share_desc = wxShare.shareDesc
        },
        setImgUrl(){
            this.imgUrl = wxShare.shareLogo
        }
    }
}

