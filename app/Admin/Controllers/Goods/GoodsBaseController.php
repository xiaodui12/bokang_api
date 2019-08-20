<?php

namespace App\Admin\Controllers\Goods;

use App\Admin\Extensions\Form\uEditor;
use App\Http\Controllers\Controller;
use Encore\Admin\Form\Field\Decimal;
use Encore\Admin\Form\Field\Editor;
use Encore\Admin\Form\Field\Id;
use Encore\Admin\Form\Field\Image;
use Encore\Admin\Form\Field\MultipleImage;
use Encore\Admin\Form\Field\Number;
use Encore\Admin\Form\Field\Text;
use Encore\Admin\Form\Field\Textarea;
use Encore\Admin\Form\Field\Select;


class GoodsBaseController extends Controller
{
    protected  $form_info=[];

    /**
     * 设置id
     *
    */
    public  function setid($name,$label,$value,$msg="")
    {
        $class=$this->get_class("id",$name,$label, $value,$msg);
        $form_info_one= ($class->render()->__toString());
        array_push($this->form_info,array("type"=>"html","html"=>$form_info_one));
    }

    /**
     * 设置input输入框
    */
    public function settext($name,$label,$value,$msg="")
    {



        $class=$this->get_class("text",$name,$label,$value,$msg);
        $class->default($value);

        $form_info_one= ($class->render()->__toString());



        array_push($this->form_info,array("type"=>"html","html"=>$form_info_one));
    }
    /**
     * 设置textarea输入框
     */
    public function settextarea($name,$label,$value=array(),$msg=""){
        $class=$this->get_class("textarea",$name,$label, $value,$msg);

        $form_info_one=$class->render()->__toString();
        array_push($this->form_info,array("type"=>"html","html"=>$form_info_one));
    }
    public function setselect($name,$label,$array, $value,$msg="")
    {
        $class=$this->get_class("select",$name,$label, $value,$msg);

        $class->options($array);
        $form_info_one=$class->render()->__toString();
        array_push($this->form_info,array("type"=>"html","html"=>$form_info_one));
    }

    public function set_number($name,$label, $value,$msg=""){
        $number=$this->get_class("number",$name,$label, $value,$msg);
        $form_info_one=$number->render()->__toString();
        array_push($this->form_info,array("type"=>"html","html"=>$form_info_one));


    }
    public function set_decima($name,$label, $value,$msg=""){
        $number=$this->get_class("decima",$name,$label, $value,$msg);
        $form_info_one=$number->render()->__toString();
        array_push($this->form_info,array("type"=>"html","html"=>$form_info_one));
    }

    /**
     * 多图上传
     *
    */
    public function set_imgs($name,$label, $value,$msg=""){

        array_push($this->form_info, array("type"=>"image","name"=>$name,"label"=>$label,"value"=>$value));
    }

    public function set_uedit($name,$label, $value,$msg="")
    {
        $uedit=$this->get_class("uedit",$name,$label, $value,$msg);
        $form_info_one=$uedit->render()->__toString();
        array_push($this->form_info,array("type"=>"html","html"=>$form_info_one));

    }


    public function set_sku($value){
        array_push($this->form_info,array("type"=>"sku","value"=>$value));
    }
    /**
     * 得到对应的class
    */
    protected function get_class($type,$name,$label,$value="",$help="")
    {
        $new_class="";
        switch ($type){
            case "id":
                $new_class=new Id($name,[$label]);
                break;
            case "text":
                $new_class=new Text($name,[$label]);
                break;
            case "decima":
                $new_class=new Decimal($name,[$label]);
                break;
            case "select":
                $new_class=new Select($name,[$label]);
                break;
            case "textarea":
                $new_class=new Textarea($name,[$label]);
                break;
            case "imgs":
                $new_class=new MultipleImage($name,[$label]);

                break;
            case "uedit":
                $new_class=new uEditor($name,[$label]);


                break;
            default:
                $new_class=new Text($name,[$label]);
        }
        if(is_array($value)){
            $new_class->fill($value);
        }else{
            $new_class->default($value);
        }

        !empty($help)&&$new_class->help($help);
        return $new_class;
    }

    /**
     * 得到form数据
    */
    public function getform_info(){
        return $this->form_info;
    }

}

