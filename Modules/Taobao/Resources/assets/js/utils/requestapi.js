import {
    createService
} from './request'

let baseURL = 'http://my.highmed.com/api/demo'
if (process.env.NODE_ENV === 'test') {
    baseURL = 'http://highmed.turingbit.cn/api/demo'
}
if (process.env.NODE_ENV === 'production') {
    baseURL = 'http://weixin.medsky.cn/api/demo'
}

export default createService(baseURL)