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
    public function indexTimeLineItems()
    {
        $timeLineItems = Post::orderBy('id', 'desc')->with('user')->paginate(5);
        foreach($timeLineItems as $timeLineItem){
            $timeLineItem['action_summary'] = unserialize($timeLineItem['action_summary']);
        }
        return $timeLineItems;
    }
}
