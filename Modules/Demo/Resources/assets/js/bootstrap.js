// 根据设备设置初始字体1rem的大小
var clientWidth = document.documentElement.clientWidth;
if(clientWidth >= 750) clientWidth = 600;
document.documentElement.style.fontSize = (clientWidth / 750) * 100 + "px";
window.onresize = function() {
    clientWidth = document.documentElement.clientWidth;
    if(clientWidth >= 750) clientWidth = 600;
    document.documentElement.style.fontSize = (clientWidth / 750) * 100 + "px"
}
