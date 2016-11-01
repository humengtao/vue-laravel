<?php
/**
 * Created by PhpStorm.
 * User: humengtao
 * Date: 2016/10/20
 * Time: 23:55
 */

namespace App\Http\Controllers\Web\Api;


use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Collection;
use App\Notifications\Notify;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function constructor()
    {
        $this->middleware('admin');
    }

    public function collectionStatus(Request $request)
    {
        Collection::where(['id' => $request->id])->update(['is_active' => $request->status]);
        if (Collection::where(['id' => $request->id])->value('is_active') == $request->status)
            return response('Success', 200);
        else
            return response('Failed', 500);
    }

    public function articleStatus(Request $request)
    {
        Article::where(['id' => $request->id])->update(['isValidated' => $request->status]);
        if (Article::where(['id' => $request->id])->value('isValidated') == $request->status){
            User::find(Article::where(['id' => $request->id])->value('user_id'))->notify(new Notify('您的文章 << '.Article::where(['id' => $request->id])->value('title').' >> 已通过审核' ));
            return response('Success', 200);
        }
        else
            return response('Failed', 500);
    }
}