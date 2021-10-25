<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    protected $fillable = ['user_id', 'name', 'category', 'status', 'experience'];

    protected $visible = ['id', 'user_id', 'name', 'category', 'status', 'experience', 'keyResults', 'actions', 'experiences'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function keyResults()
    {
        return $this->hasMany(KeyResult::class);
    }

    function actions()
    {
        return $this->hasMany(Action::class);
    }

    function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}
