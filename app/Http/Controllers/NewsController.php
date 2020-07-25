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
        $data = News::paginate(20);
        return view('news', compact('data'));
    }

    function AddNews(Request $request){
        $request->validate([
            'news_title' => 'required',
            'news_text' => 'required',
            'news_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        //$pathToImage = $request->file('news_image')->store('storage', 'public');

        //Get file from the browser
        $path= $request->file('news_image');
        // Resize and encode to required type
        $img = Image::make($path)->resize(500,500)->encode();
        //Provide the file name with extension
        $filename = time(). '.' .$path->getClientOriginalExtension();
        //Put file with own name
        Storage::put($filename, $img);
        //Move file to your location
        Storage::move($filename, 'public/news_images/' . $filename);


        $newsData = $request->all();
        $newsData['news_image'] = $filename;
        $newsData['date'] = Carbon::now()->format('d.m.Y');

        //$news = News::create($newsData);

        return Response::json(1);
    }
}
