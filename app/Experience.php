<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = ['user_id', 'objective_id', 'key_result_id', 'action_id', 'experience', 'count'];

    protected $visible = ['id', 'user_id', 'objective_id', 'key_result_id', 'action_id', 'action_date', 'experience', 'count'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function objective()
    {
        return $this->belongsTo(Objective::class);
    }

    function keyResult()
    {
        return $this->belongsTo(KeyResult::class);
    }

    function action()
    {
        return $this->belongsTo(Action::class);
    }

    function post()
    {
        return $this->belongsTo(Post::class);
    }
}