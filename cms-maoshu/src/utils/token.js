const Tokenkey = 'admin_user_token'
const TokenExpirekey = 'admin_user_token_expire'
// 获取token
export function getToken(){
    let token = localStorage.getItem(Tokenkey)
    if(token){
        // 判断是否超时
        let expire = localStorage.getItem(TokenExpirekey)

        if(new Date().getTime() > expire){
            removeToken()
            token = null
        }
    }
    return token
}

// 设置token
export function setToken(token){
    localStorage.setItem(Tokenkey,token)
    localStorage.setItem(TokenExpirekey,new Date().getTime() + 60*60*1000)
}

// 删除token
export function removeToken(){
    localStorage.removeItem(Tokenkey)
    localStorage.removeItem(TokenExpirekey)
}