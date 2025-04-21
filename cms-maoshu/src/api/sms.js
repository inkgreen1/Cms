import {post,get} from '@/utils/request'

export function resetPwdSms(data){
    return post({
        url:'/sms/pwd',
        data
    })
}

export function BindphoneSms(data){
    return post({
        url:'/sms/bindphone',
        data
    })
}