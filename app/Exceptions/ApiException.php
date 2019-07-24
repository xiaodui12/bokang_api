<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 14:43
 */

namespace App\Exceptions;



class ApiException extends  \Exception
{
    protected $data;
    function __construct($msg='',$code=0,$data=array())
    {
        parent::__construct($msg,$code);
        $this->data=$data;
    }
    public function get_e_data(){
        return $this->data;
    }
}