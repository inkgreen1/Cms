import {
    post,
    get
} from '@/utils/request'

export function uploadFile(file,category=null) {
    return post({
        url: '/upload/file',
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        data: {
            file,
            category
        }
    })
}

export function uploadFiles(files, category = null) {
    return post({
        url: '/upload/files',
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        data: {
            files,
            category
        }
    })
}