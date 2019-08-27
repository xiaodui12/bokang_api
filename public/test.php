<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/24
 * Time: 19:17
 */

error_reporting(7);
// 返回二进制流数据
$file_path = "http://qiniu.chuangchengkj.cn/185_18.mp4?avvod/m3u8";




$oct_data=file_get_contents($file_path);
$oct_data=str_replace("/185_18.mp4","http://qiniu.chuangchengkj.cn/185_18.mp4",$oct_data);


$index=strpos($oct_data,"seg0010.ts");
$oct_data=substr($oct_data,0,$index+11);


header("Content-type: video/m3u8;charset=UTF-8");
//header("Content-Length: " . $file_size);
echo $oct_data;
echo "#EXT-X-ENDLIST";