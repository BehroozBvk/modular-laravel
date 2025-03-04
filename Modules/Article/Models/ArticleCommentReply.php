<?php

namespace Modules\Article\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Article\Database\Factories\ArticleCommentReplyFactory;

class ArticleCommentReply extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): ArticleCommentReplyFactory
    // {
    //     // return ArticleCommentReplyFactory::new();
    // }
}
