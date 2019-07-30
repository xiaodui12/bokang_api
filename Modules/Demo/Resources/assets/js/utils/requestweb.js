import {
    createService
} from './request'

let baseURL = 'http://my.highmed.com/demo'
if (process.env.NODE_ENV === 'test') {
    baseURL = 'http://highmed.turingbit.cn/demo'
}
if (process.env.NODE_ENV === 'production') {
    baseURL = 'http://weixin.medsky.cn/demo'
}

export default createService(baseURL)