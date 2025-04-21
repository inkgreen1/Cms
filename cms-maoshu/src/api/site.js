import {post,get} from '@/utils/request'

export function getSiteinfo(){
    return get({
        url:"/site/getinfo"
    })
}