<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'token', 'experience',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id', 'name', 'email', 'profile_image', 'profile_mini_image', 'profile_bg_image', 'profile_bg_mini_image' ,
        'experience','objectives', 'keyResults', 'actions', 'posts', 'experiences', 'study_experience',
        'bodymake_experience', 'business_experience', 'money_experience', 'hobby_experience',
        'life_experience', 'other_experience', 'myId'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // IdentityProviderモデルと紐付ける 1対多の関係
    function identityProviders()
    {
        return $this->hasMany(IdentityProvider::class);
    }

    // Objectiveモデルと紐付ける 1対多の関係
    function objectives()
    {
        return $this->hasMany(Objective::class);
    }

    // KeyResultモデルと紐付ける 1対多の関係
    function keyResults()
    {
        return $this->hasMany(KeyResult::class);
    }

    // Actionモデルと紐付ける 1対多の関係
    function actions()
    {
        return $this->hasMany(Action::class);
    }

    // Experienceモデルと紐付ける 1対多の関係
    function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    // Postモデルと紐付ける 1対多の関係
    function posts()
    {
        return $this->hasMany(Post::class);
    }
}
