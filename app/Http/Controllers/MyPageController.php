<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileImageSetting;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * マイページ情報取得
    */
    public function indexMyPage(Request $request)
    {
        $user = User::find(Auth::id());
        return $user;
    }

    /**
     * 目標設定
     * @param ProfileImageSetting $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfileImage(ProfileImageSetting $request)
    {
        $img = $request->profileImage;
        $img = str_replace(' ' , '+' , $img);
        $img = preg_replace('#^data:image/\w+;base64,#i' , '' , $img);
        $img = base64_decode($img);
        $imgData = imagecreatefromstring($img);
        $tday = time();
        $filename = Auth::id() . '_' .$tday . '.png';
        $imagePng = imagepng($imgData, public_path('storage/profile/' . $filename));
        imagedestroy($imgData);
        $user = User::find(Auth::id());
        $user->profile_image = '/storage/profile/' . $filename;
        $user->save();
        return response('update success!!', 201);
    }
}