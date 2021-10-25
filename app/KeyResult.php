<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyResult extends Model
{
    protected $fillable = ['user_id', 'objective_id', 'name', 'status', 'experience'];

    protected $visible = ['id', 'user_id', 'objective_id', 'name', 'status', 'experience', 'actions', 'experiences'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function objective()
    {
        return $this->belongsTo(Objective::class);
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
