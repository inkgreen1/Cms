import {
    post,
    get
} from '@/utils/request'

export function getCatePidList() {
    return get({
        url: '/cate/pidlist'
    })
}

export function getCateList(data) {
    return post({
        url: '/cate/list',
        data
    })
}