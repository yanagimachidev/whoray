<?php

namespace App\Http\Controllers;

use App\User;
use App\Action;
use App\Experience;
use App\Post;
use App\Http\Requests\ActionPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DailyActionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 目標一覧
     */
    public function indexActionPost(Request $request)
    {
        $pDate = $request->input('postdate');
        $actionPost = Post::where([['user_id', Auth::id()], ['action_date', $pDate]])->first();
        if(isset($actionPost)){
            $actionPost['actions'] = unserialize($actionPost['action_summary']);
            return $actionPost;
        }else if($pDate >= date("Y-m-d", strtotime('-1 day'))){
            $actionPost['actions'] = Action::where('user_id', Auth::id())->get();
            return $actionPost;
        }else{
            return $actionPost;
        }
    }

    /**
     * 目標設定
     * @param ActionPost $request
     * @return \Illuminate\Http\Response
     */
    public function createActionPost(ActionPost $request)
    {
        $post = new Post();
        $post->action_summary = serialize($request->get('actions'));
        $post->action_text = $request->get('actionText');
        $post->action_date = $request->get('actionDate');
        $post->comment_cnt = 0;
        $post->like_cnt = 0;
        Auth::user()->posts()->save($post);

        $actions = $request->get('actions');
        foreach($actions as $action){
            $experience = new Experience();
            $experience->objective_id = $action['objective_id'];
            $experience->key_result_id = $action['key_result_id'];
            $experience->action_id = $action['id'];
            $experience->post_id = $post->id;
            $experience->action_date = $request->get('actionDate');
            $experience->experience = $action['experience'];
            $experience->count = $action['count'];
            Auth::user()->experiences()->save($experience);
        }

        return response($post, 201);
    }
}
