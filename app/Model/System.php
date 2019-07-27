<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{

    protected $table = 'bokang_system';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $pdd_config_string=["pdd_client_secret","pdd_client_id"];//拼多多配置键值
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * 初始化配置
    */
    public static function init_config()
    {
        $config= cache("System_config");//得到緩存中配置
        //当缓存不存在时候，重新查数据库
        if(empty($config))
        {
            $config=array();
            $list=self::where("status",1)->get();

            //循环配置数据
            foreach ($list as $key=>$value){
                $config[$value->key]=$value->value;
            }
            cache(["System_config"=>$config],3600);//新数据新增入缓存
        }
        config($config);
        return true;
    }

    /**
     * 静态函数得到拼多多配置
     *
    */
    public static function getpdd()
    {
        self::init_config();
        $pdd_config=array();
        $pdd_config_string=(new self())->pdd_config_string;
        foreach ($pdd_config_string as $value){
            $pdd_config[$value]=config($value);
        }
       return $pdd_config;
    }
}
