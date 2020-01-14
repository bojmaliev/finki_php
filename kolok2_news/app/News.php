<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = ['news_title', 'news_link', 'news_description'];

    public function comments()
    {
        return $this->hasMany(NewsComment::class);
    }
}
