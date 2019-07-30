export function isWeiXin() {
    return navigator.userAgent.toLowerCase().indexOf('micromessenger') !== -1
}