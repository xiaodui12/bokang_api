import {
    createService
} from './request'


let baseURL = 'http://my.highmed.com/api'
if (process.env.NODE_ENV === 'test') {
    baseURL = 'http://highmed.turingbit.cn/api'
}
if (process.env.NODE_ENV === 'production') {
    baseURL = 'http://weixin.medsky.cn/api'
}

export default createService(baseURL)