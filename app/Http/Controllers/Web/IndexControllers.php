<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 8:53
 */

namespace App\Http\Controllers\Web;



use App\Model\Order;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\Response;

class IndexControllers extends WebControllers
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        echo 111;
    }

    public function get_order_img(Request $request)
    {
        $order_id=$request->input("order_id","");

        list($price,$point)=Order::getorder_share($order_id);

        $bg="images/share_bg.png";
        $fonttitle="fonts/msyh.ttf";




        // 修改指定图片的大小
        $img = Image::make($bg)->resize(750, 640);

        $img->text($point, 400,460, function ($font) use ($fonttitle) {
            $font->file($fonttitle);
            $font->size(23);
            $font->valign('left');
            $font->color("#ff0000");
        });
        $img->text('￥ '.$price, 400,545, function ($font) use ($fonttitle) {
            $font->file($fonttitle);
            $font->size(23);
            $font->valign('left');
            $font->color("#ff0000");
        });
//

        $response=new Response($img->encode('jpg'));
        return $response->make();

    }
}