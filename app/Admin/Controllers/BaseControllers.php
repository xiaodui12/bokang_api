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
               $model->disablePagination();

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



    public static function setlist_show($model,$array){
        foreach ($array as $key=>$value){

            $field=$model->column($value["field"], __($value["title"]));
            switch ($value["type"]){
                case "image":
                    $field->image("",60,60);
                    break;
                case "datetime":
                    $field->display(function ($time){
                        return$time?date("Y-m-d H:i:s",$time):"----:--:--";
                    });
                    break;
                case "date":
                    $field->display(function ($time){
                        return $time?date("Y-m-d",$time):"----:--:--";
                    });
                    break;
                case "array":
                    $field->using($value["array"]);
                    break;
                case "boolean":
                    $field->display(function ($boolean){
                        return $boolean?"是":"否";
                    });
                    break;
                case "expand":
                    $field->expand($value["function"]);
            }
        }
    }
}
