/* 是否是整数*/
export function validatInteger(str) {
    const reg = /^-?\d+$/
    return reg.test(str)
}

/* 是否是正整数 */
export function validatePositiveInteger(str) {
    const reg = /^[1-9]\d*$/
    return reg.test(str)
}

/* 是否是正数 */
export function validatePositiveNumber(str) {
    const reg = /^\d+(\.\d{1,})?$/
    return reg.test(str)
}

