<?php
/**
 * Created by PhpStorm.
 * User: humengtao
 * Date: 16/9/17
 * Time: 22:26
 */

namespace App\Http\Controllers\Web;

use App\Models\Article;
use App\Models\Collection;
use App\Models\Comment;
use App\Models\Records;
use App\User;
use DB;
use App\Http\Controllers\Controller;
use Mail;
use YuanChao\Editor\EndaEditor;

class IndexController extends Controller
{
    public function index($collection)
    {
        if ($collection != 'all')
            $articles = Article::where(['collection' => $collection])->orderBy('created_at', 'desc')->paginate(20);
        else
            $articles = Article::orderBy('created_at', 'desc')->paginate(20);

        foreach ($articles as $article) {
            $article->comment_count = Comment::where('article_id', $article->id)->count();
            $article->content = EndaEditor::MarkDecode($article->content);
            $content = Article::where('id', $article->id)->first();
            preg_match_all('/<img.*?src="(.*?)".*?>/is',EndaEditor::MarkDecode($content->content),$result);
            $article->avatar=$result[1];
        }
        $collections=Collection::all();

        return view('web.component.articles.articles', compact('articles','collections'));
    }

    public function collection()
    {
        $collections = Collection::where('is_active',1)->get();
        return view('face-page', compact('collections'));
    }

    public function recommend(){
        $articles=Article::orderBy('view','desc')->limit(9)->get();
        foreach ($articles as $article){
            $article->total_view=$article->where('user_id',$article->user_id)->sum('view');
        }
        return view('web.music',compact('articles'));
    }
}
