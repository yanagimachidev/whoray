<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'action_summary', 'action_text', 'action_date', 'comment_cnt', 'like_cnt'];

    protected $visible = ['id', 'user_id', 'user', 'action_summary', 'action_text', 'action_date', 'comment_cnt', 'like_cnt', 'actions', 'experiences'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}
