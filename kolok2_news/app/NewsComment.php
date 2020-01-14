<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsComment extends Model
{
    protected $table = 'news_comment';

    protected $fillable = ['username', 'comment_text'];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
