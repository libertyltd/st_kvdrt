<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    public $timestamps = false;
    protected $fillable = ['date_create', 'name', 'email', 'message', 'post_id', 'post_comment_id'];

    //Возвращает пост, которому принадлежит
    public function post () {
        return $this->belongsTo('App\Post');
    }

    public function answer () {
        return $this->hasOne('App\PostComment');
    }

    public function postCommnet () {
        return $this->belongsTo('App\PostComment');
    }
}
