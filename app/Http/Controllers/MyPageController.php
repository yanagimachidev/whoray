<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileImageSetting;
use App\Http\Requests\MyInfoUpdate;
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
        if($request->has('userid')){
            $userId = $request->input('userid');
        }else{
            $userId = Auth::id();
        }
        $user = User::find($userId);
        $user->myId = Auth::id();
        return $user;
    }

    /**
     * 画像設定
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

/**
     * マイページ情報更新
     * @param MyInfoUpdate $request
     * @return \Illuminate\Http\Response
     */
    public function myInfoUpdate(MyInfoUpdate $request)
    {
        $user = User::find(Auth::id());
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->save();
        return response('update success!!', 201);
    }
}