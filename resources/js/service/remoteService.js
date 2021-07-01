import axios from "axios"


const env = process.env.NODE_ENV || 'local'
const development = 'development'
const production = 'production'
const isProd = env === production

const instanceAxios = axios.create({
    baseURL: '/',
    timeout: 10000,
    headers: {}
})

instanceAxios.interceptors.request.use(config => {
    // if (config.method === 'post') {
    //     // config.data = JSON.stringify(config.data) // 转为formdata数据格式
    //     // config.data = JSON.stringify({
    //     //     ...config.data
    //     // })
    //     config.params = {
    //         access_token: localStorage.getItem('access_token')
    //     }
    // } else if (config.method === 'get') {
    //
    //     config.params = {
    //         access_token: localStorage.getItem('access_token'),
    //         ...config.params
    //     }
    // }
    return config;
});

instanceAxios.interceptors.response.use(response => {
    const res = response.data
    if (res.code !== 1) {
        if (res.code === 0) {
            Message({
                message: res.msg || 'Error',
                type: 'error',
                duration: 5 * 1000
            })
        }
    }
    return res
    // 对响应数据做点什么
    // return response;
}, function (error) {
    // 错了就退出登陆
    if (isProd) {
        Message.error(error.message)
    } else {
        Message.error(error.message)
    }

    // 对响应错误做点什么
    return Promise.reject(error);
})
const remoteService = {}
remoteService.about = function () {
    return instanceAxios.get('api/about')
}
export {remoteService}
