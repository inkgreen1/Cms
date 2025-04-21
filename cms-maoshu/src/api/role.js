import {get,post} from '@/utils/request'

export function getRuleList(param){
    return get({
        url:'/role/getrulelist',
        data:param
    })
}

export function getRoleList(data){
    return post({
        url:'/role/list',
        data:data
    })
}

export function getFullRulelistbyid(id) {
    return get({
        url: '/role/getrulelistbyid',
        data: {
            id,
            onlychildren:0
        }
    })
}