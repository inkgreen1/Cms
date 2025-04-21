const Key = 'admin_uname_pwd'
// 获取token
export function getUnamePwd(){
    let info = localStorage.getItem(Key)
    if(info){
        let infoObj = JSON.parse(info)
        infoObj.pwd = atob(infoObj.pwd)
        return infoObj
    }
    return null
}

// 设置token
export function setUnamePwd(info){
    info.pwd = btoa(info.pwd)
    info = JSON.stringify(info)
    localStorage.setItem(Key,info)
}

// 删除token
export function removeUnamePwd(){
    localStorage.removeItem(Key)
}