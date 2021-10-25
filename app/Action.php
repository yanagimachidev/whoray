<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['user_id', 'objective_id', 'key_result_id', 'name', 'status', 'unit', 'experience', 'count'];

    protected $visible = ['id', 'user_id', 'objective_id', 'key_result_id', 'name', 'status', 'unit', 'experience', 'count', 'experiences'];

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

    function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}
