<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/26
 * Time: 16:14
 */

namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;

class BaseControllers extends Controller
{
    /**
     * 修改后台版面条件
     * $type  1：列表（可以添加）
     * 2：列表（不可以添加）
     * 3：详情列表
     * 4：详情详情
     * 5：列表头部
     */
    public static function set_auth($model,$type)
    {
        switch ($type){
            case 1:
                break;
            case 2:
                $model->disableCreateButton();

                break;
            case 3:
                $model->disableCreateButton();
                $model->disablePagination();
                $model->disableFilter();
                $model->disableExport();
                $model->disableRowSelector();
                $model->disableActions();
                $model->disableColumnSelector();
                break;
            case 4:
                $model->panel()
                    ->tools(function ($tools) {
                        $tools->disableEdit();
                        $tools->disableList();
                        $tools->disableDelete();
                    });
                break;
            case 5:
                $model->panel()
                    ->tools(function ($tools) {
                        $tools->disableEdit();
//                       $tools->disableList();
                        $tools->disableDelete();
                    });
                break;
        }
    }



    /**
     * 拼接后台列表数据
     * $model 模型
     * $array  待拼接数据
    */
    public static function setlist_show($model,$array){
        //循环待拼接数据
        foreach ($array as $key=>$value){
            $field=$model->column($value["field"], __($value["title"]));//初始化数据
            //根据不同显示类型展示不同样式
            switch ($value["type"]){
                case "image"://图片类型展示图片
                    $field->image("",60,60);
                    break;
                case "datetime"://时分秒类型
                    $field->display(function ($time){
                        return$time?date("Y-m-d H:i:s",$time):"----:--:--";
                    });
                    break;
                case "date"://日期类型
                    $field->display(function ($time){
                        return $time?date("Y-m-d",$time):"----:--:--";
                    });
                    break;
                case "array"://数组类型
                    $field->using($value["array"]);
                    break;
                case "boolean"://布尔类型判断是否正确
                    $field->display(function ($boolean){
                        return $boolean?"是":"否";
                    });
                    break;
                case "expand"://expand 下拉展示类型，直接传递function
                    $field->expand($value["function"]);
                    break;
                case "default":
                    $field->display(function ($default) use($value){
                        return $default?$default:$value["default"];
                    });


            }
        }
    }

    public static function setdetail($model,$array)
    {
        foreach ($array as $key=>$value){
            $field=$model->field($value["field"], __($value["title"]));
            switch ($value["type"]){
                case "image":
                    $field->image("",60,60);
                    break;
                case "datetime":
                    $field->as(function ($time){
                        return$time?date("Y-m-d H:i:s",$time):"----:--:--";
                    });
                    break;
                case "date":
                    $field->as(function ($time){
                        return $time?date("Y-m-d",$time):"----:--:--";
                    });
                    break;
                case "array":
                    $field->using($value["array"]);
                    break;
                case "boolean":
                    $field->as(function ($boolean){
                        return $boolean?"是":"否";
                    });
                    break;
                case "use":
                    $detail=$value["detail"];
                    $field->as(function ($boolean) use($detail){
                        return $detail;
                    });
                    break;
            }
        }
    }
    public static function set_form($model,$array)
    {
        foreach ($array as $key=>$value){
            switch ($value["type"]){
                case "display":
                    $model->display($value["field"], $value["title"]);
                    break;
                case "text":
                    $model->text($value["field"], $value["title"]);
                    break;
                case "textarea":
                    $model->textarea($value["field"], $value["title"]);
                    break;
                case "select":
                    $model->select($value["field"], $value["title"])->options($value["array"]);
                    break;
                case "switch":
                    $model->switch($value["field"], $value["title"]);
                    break;
                case "image":
                    $model->image($value["field"], $value["title"]);
                    // 使用随机生成文件名 (md5(uniqid()).extension)
//                    $model->image($value["field"])->uniqueName();
                    break;
                case "date":
                    $model->date($value["field"], $value["title"])->format('YYYY-MM-DD');
                    // 添加日期时间选择框
                    break;
                case "datetime":
                    $model->datetime($value["field"], $value["title"])->format('YYYY-MM-DD HH:mm:ss');
                    // 添加日期时间选择框
                    break;
                case "timeRange":
                    $model->timeRange($value["field"][0], $value["field"][1],  $value["title"]);
                    // 添加日期时间选择框
                    break;
                case "dateRange":
                    $model->dateRange($value["field"][0], $value["field"][1],  $value["title"]);
                    // 添加日期时间选择框
                    break;
                case "datetimeRange":
                    $model->datetimeRange($value["field"][0], $value["field"][1],  $value["title"]);
                    // 添加日期时间选择框
                    break;
                case "number":
                    $model->number($value["field"],$value["title"]);
                    break;

            }
        }

    }
}
