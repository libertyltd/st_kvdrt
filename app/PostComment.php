<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    public $timestamps = false;
    protected $fillable = ['date_create', 'name', 'email', 'message', 'post_id', 'post_comment_id'];
}
