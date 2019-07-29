import axios from 'axios'
import {Message} from 'element-ui'
import store from '@/store'
import {getToken} from './auth'

export function createService(baseURL) {
    // 创建axios实例
    const service = axios.create({
        baseURL: baseURL, // api 的 base_url
        timeout: 5000 // 请求超时时间
    })

    // request拦截器
    service.interceptors.request.use(
        config => {
            if (store.getters.token) {
                config.headers['Authorization'] = 'Bearer ' + getToken() // 让每个请求携带自定义token 请根据实际情况自行修改
            }
            return config
        },
        error => {
            // Do something with request error
            console.log('request error :' + error) // for debug
            Promise.reject(error)
        }
    )

    // response 拦截器
    service.interceptors.response.use(
        function(response) {
            /**
             * code为非200是抛错 可结合自己业务进行修改
             */
            const res = response.data
            if (res.code !== 200) {
                Message({
                    message: res.message,
                    type: 'error',
                    duration: 10 * 1000
                })
                return Promise.reject('error')
            } else {
                return response.data
            }
        }, function(error) {
            if (error.response) {
                switch (error.response.status) {
                    case 401:
                        MessageBox.confirm(
                            '你已被登出，可以取消继续留在该页面，或者重新登录',
                            '确定登出',
                            {
                                confirmButtonText: '重新登录',
                                cancelButtonText: '取消',
                                type: 'warning'
                            }
                        ).then(() => {
                            store.dispatch('FedLogOut').then(() => {
                                location.reload() // 为了重新实例化vue-router对象 避免bug
                            })
                        })
                        break
                    case 403:
                        Message({
                            message: '403:请求地址禁止访问',
                            type: 'error',
                            duration: 5 * 1000
                        })
                        break
                    case 404:
                        Message({
                            message: '404:请求地址不存在',
                            type: 'error',
                            duration: 5 * 1000
                        })
                        break
                    case 500:
                        Message({
                            message: '500:服务器内部出错',
                            type: 'error',
                            duration: 5 * 1000
                        })
                        break
                    default:
                        Message({
                            message: error.message,
                            type: 'error',
                            duration: 5 * 1000
                        })
                        break
                }
            }
            return Promise.reject(error)
        }
    )

    return service
}