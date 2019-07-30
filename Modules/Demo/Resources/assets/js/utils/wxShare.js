let baseURL = 'http://my.highmed.com'
if (process.env.NODE_ENV === 'test') {
    baseURL = 'http://highmed.turingbit.cn'
}
if (process.env.NODE_ENV === 'production') {
    baseURL = 'http://weixin.medsky.cn'
}

export default {
    baseURL: baseURL,
    shareTitle: 'DEMO',
    shareDesc: 'DEMO',
    shareLogo: baseURL + '/images/demo/logo.png'
}