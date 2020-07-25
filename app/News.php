<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = ['id'];
    protected $fillable = ['title', 'news_test', 'news_image', 'date'];
}
