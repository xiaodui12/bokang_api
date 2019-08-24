<?php


/**
 * curl post 提交
 * 参数  $url 提交连接
 *       $post_data  提交内容
 */
function curlPostPay($url,$post_data,$type="json"){
    //初始化
    $curl = curl_init();



    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);

    $headers=[
        "Content-Type:application/x-www-form-urlencoded"
    ];
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSLVERSION, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
    curl_setopt($curl, CURLOPT_POST, 1);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    //执行命令
    $data = curl_exec($curl);
    $error_no=curl_errno($curl);

    //关闭URL请求
    curl_close($curl);
    $error_no!=0&&error_return("外部接口调取错误，错误码：".$error_no);


    return json_decode($data);


}


/**
 * curl post 提交
 * 参数  $url 提交连接
 *       $post_data  提交内容
 */
function curlPost($url,$post_data,$type="json"){
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);


    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSLVERSION, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
    curl_setopt($curl, CURLOPT_POST, 1);

    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
    //执行命令
    $data = curl_exec($curl);
    $error_no=curl_errno($curl);

    //关闭URL请求
    curl_close($curl);
    $error_no!=0&&error_return("外部接口调取错误，错误码：".$error_no);


    if($type=="json"){
        return json_decode($data);
    }else{
        return $data;
    }

}
/**
 * curl get 提交
 * 参数  $url 提交连接
 *
 */
function curlGet($url,$header=''){
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    if(!empty($header)){

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSLVERSION, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    //执行命令
    $data = curl_exec($curl);
    $error_no=curl_errno($curl);
    //关闭URL请求
    curl_close($curl);

    $error_no!=0&&error_return("外部接口调取错误，错误码：".$error_no);

    return json_decode($data,1);
}


/**
 * 成功返回
 *$data 成功数据
 * $msg  成功提示语
*/
function success_return($data,$msg=""){

        throw new \App\Exceptions\ApiException($msg,0,$data);
}
/**
 * 失败返回
 * $msg 失败原因
*/
function error_return($msg=""){
        throw new \App\Exceptions\ApiException($msg,-1);
}

/**
 * 昵称转码
*/
 function filterEmoji($str)
{
    $str = preg_replace_callback(
        '/./u',
        function (array $match) {
            return strlen($match[0]) >= 4 ? '' : $match[0];
        },
        $str);

    return $str;
}


/**
 * 时间戳转时间
*/
function getdatatime($time){
     return date("Y-m-d H:i:s",$time);
}

//PHP stdClass Object转array
function object_array($array) {
    if(is_object($array)) {
        $array = (array)$array;
    } if(is_array($array)) {
        foreach($array as $key=>$value) {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}


/**
 * 判断是否是微信
*/
function is_weixin()
{
    return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ?true:false;
}