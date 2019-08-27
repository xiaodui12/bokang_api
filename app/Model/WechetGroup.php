<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WechetGroup extends Model
{
    protected $table = 'bokang_wechet_group';

    public function getListByDistance($lon,$lat)
    {


        $select="ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN( 
        (".$lat." * PI() / 180 - lat * PI() / 180) / 2),
        2) + 
        COS(".$lat." * PI() / 180) * COS(lat * PI() / 180) * 
        POW(
        SIN(
        (".$lon." * PI() / 180 - lon * PI() / 180 )
         / 2),2 ))) ) AS juli";

        return $this->where("status",1)->select("*",DB::raw($select))->get();

    }


    public function getDetail($id)
    {

        return $this->find($id);
    }
}
