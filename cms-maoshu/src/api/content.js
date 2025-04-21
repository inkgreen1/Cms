import {
    post,
    get
} from '@/utils/request'

export function changeStatus(data) {
    return post({
        url: '/content/changestatus',
        data
    })
}

export function changeAudit(data) {
    return post({
        url: '/content/changeaudit',
        data
    })
}