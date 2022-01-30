<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * タイムライン一覧
     */
    public function indexTimeLineItems(Request $request)
    {
        if($request->has('userid')){
            $userId = $request->input('userid');
            $timeLineItems = Post::orderBy('id', 'desc')->where('user_id', $userId)->with('user')->paginate(5);
        }else{
            $timeLineItems = Post::orderBy('id', 'desc')->with('user')->paginate(5);
        }
        foreach($timeLineItems as $timeLineItem){
            $timeLineItem['action_summary'] = unserialize($timeLineItem['action_summary']);
            $timeLineItem['action_date'] = substr($timeLineItem['action_date'], 0, 4) . "年" .
                ltrim(substr($timeLineItem['action_date'], 5, 2), "0") . "月" .
                ltrim(substr($timeLineItem['action_date'], 8, 2), "0") . "日";
        }
        return $timeLineItems;
    }
}
