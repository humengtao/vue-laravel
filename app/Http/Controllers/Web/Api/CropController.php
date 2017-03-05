<?php
/**
 * Created by PhpStorm.
 * User: humengtao
 * Date: 2017/3/5
 * Time: 18:31
 */

namespace App\Http\Controllers\Web\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CropController extends Controller
{
    private $img;

    public function upload(Request $request)
    {
        $this->deleteTempFile($request);
        $filename = md5($request->user()->email).random_int(0,999999999999999) . '.png';
        $path=public_path('temp/avatar/'.$filename);
        $this->img = Image::make(file_get_contents($request->file('img')->getRealPath()));
        $this->resize()->save($path);
        $request->session()->put('avatar_temp',$filename);
        return asset('temp/avatar/'.$filename);

//----------------------------------------------------
    }

    protected function resize()
    {
        $w = $this->img->width();
        $h = $this->img->height();
        if ($w >= $h) {
            $this->img->resize(400, $h * 400 / $w);
        } else {
            $this->img->resize($w * 400 / $h, 400);
        }
        return $this->img;
    }


    public function size(Request $request)
    {
        $filename = $request->user()->email . '.png';
        $path = storage_path('app/public/avatar/') . $filename;
        $this->img = Image::make(file_get_contents('temp/avatar/'.$request->session()->get('avatar_temp')));
        $this->img->crop($request->w, $request->h, $request->x, $request->y)->save($path);
//        $this->deleteTempFile($request);
        return redirect('/setting');
    }

    public function deleteTempFile($request){
        if($request->session()->has('avatar_temp')){
            File::delete('temp/avatar/'.$request->session()->get('avatar_temp'));
        }
    }
}