import request from '@/utils/requestwechat'

// 获取微信js sdk配置
export function config(params) {
    return request({
        url: '/js-share-config',
        method: 'get',
        params
    })
}