import {post,get} from '@/utils/request'

export function login(data){
    return post({
        url:'/user/login',
        data
    })
}
export function resetpwdByPhone(data){
    return post({
        url:'/user/resetpwd',
        data
    })
}

export function BindPhone(data){
    return post({
        url:'/personal/bindphone',
        data
    })
}

export function getUserinfo(){
    return get({
        url:'/user/userinfo'
    })
}

export function userLogout(){
    return post({
        url:'/user/logout'
    })
}