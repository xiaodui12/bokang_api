import request from '@/utils/requestapi'
import webrequest from '@/utils/requestweb'

export function index() {
    return request({
        url: '/index',
        method: 'get'
    })
}


// 是否需要关注弹框
export function subscribe(openid) {
    return request({
        url: '/subscribe/'+openid,
        method: 'get'
    })
}

// 获取OPENID
export function getOpenId() {
    return webrequest({
        url: '/openid',
        method: 'get',
    })
}

