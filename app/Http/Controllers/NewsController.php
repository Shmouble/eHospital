<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    function index(){
        $allNews = DB::table('news')->latest('created_at')->paginate(10);
        return view('news', compact('allNews'));
    }

    function AddNews(Request $request){
        $request->validate([
            'news_title' => 'required',
            'news_text' => 'required',
            'news_description' => 'required',
            'news_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $pathToImage = $request->file('news_image')->store('news_images', 'public');

        $newsData = $request->all();
        $newsData['news_image'] = $pathToImage;
        $newsData['date'] = Carbon::now();//->format('d.m.Y');

        $news = News::create($newsData);

        return Response::json($news);
    }

    function readNews($id){
        $news = DB::table('news')->find($id);

        if($news){
            return view('readNews', compact('news'));
        }

        return abort(404);
    }
}
