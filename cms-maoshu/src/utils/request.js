import axios from 'axios'
import { getToken,removeToken } from '@/utils/token';
import { ElMessage } from 'element-plus';

// export const apiDomain = 'https://apifoxmock.com/m1/4756381-4409655-default'
export const Domain = import.meta.env.VITE_BASE_URL
export const apiDomain = Domain+'/admin'
const request = axios.create({
    baseURL: apiDomain,
    timeout: 5000,
    withCredentials: true
});

// 添加请求拦截器
request.interceptors.request.use(function (config) {
    const token = getToken()
    if(token){
        config.headers['Authorization'] = token
    }
    // console.log('config: ', config);
    // 在发送请求之前做些什么
    return config;
  }, function (error) {
    // 对请求错误做些什么
    return Promise.reject(error);
  });

// 添加响应拦截器
request.interceptors.response.use(function (response) {
    console.log('response: ', response);
    // 2xx 范围内的状态码都会触发该函数。
    // 对响应数据做点什么
    return response.data;
  }, function (error) {
    console.log('error: ', error);
    // 超出 2xx 范围的状态码都会触发该函数。
    // 对响应错误做点什么
    if(error.response && error.response.status === 404){
        ElMessage.error('请求接口不存在')
    }
    else if(error.response && error.response.status === 401){
        ElMessage.error('登录已失效，请重新登录')
        removeToken()
        window.location.reload()
    }
    else{
        ElMessage.error('请求异常，请检查服务器状态')
    }
    return Promise.reject(error);
  });

export const post = (obj)=>{
    obj.method = 'POST'
    return request(obj)
}


export const get = (obj)=>{
    obj.method = 'GET'
    if(obj.data){
        obj.url += '?' + Object.keys(obj.data).map(key=> key+'='+obj.data[key]).join('&')
    }
    return request(obj)
}