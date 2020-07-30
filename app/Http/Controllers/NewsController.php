<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    function index(){
        $allNews = News::paginate(10);
        return view('news', compact('allNews'));
    }

    function AddNews(Request $request){
        $request->validate([
            'news_title' => 'required',
            'news_text' => 'required',
            'news_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $pathToImage = $request->file('news_image')->store('news_images', 'public');

        $newsData = $request->all();
        $newsData['news_image'] = $pathToImage;
        $newsData['date'] = Carbon::now();//->format('d.m.Y');

        $news = News::create($newsData);

        return Response::json($news);
    }
}
