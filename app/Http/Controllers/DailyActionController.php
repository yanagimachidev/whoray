<?php

namespace App\Http\Controllers;

use App\User;
use App\Objective;
use App\KeyResult;
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
     * 投稿用のデイリーアクションの取得
     */
    public function indexActionPost(Request $request)
    {
        $pDate = $request->input('postdate');
        $actionPost = Post::where([['user_id', Auth::id()], ['action_date', $pDate]])->first();
        if(isset($actionPost)){
            $actionPost['actions'] = unserialize($actionPost['action_summary']);
            return $actionPost;
        }else if($pDate >= date("Y-m-d", strtotime('-1 day'))){
            $actionPost['actions'] = Action::where([['user_id', Auth::id()], ['status', '積み上げ中']])->get();
            return $actionPost;
        }else{
            return $actionPost;
        }
    }

    /**
     * デイリーアクション追加
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

            $act = Action::find($action['id']);
            $act->experience = $act->experience + $action['experience'];
            $act->count = $action['count'];
            $act->save();

            $kr = KeyResult::find($action['key_result_id']);
            $kr->experience = $kr->experience + $action['experience'];
            $kr->save();

            $ojt = Objective::find($action['objective_id']);
            $ojt->experience = $ojt->experience + $action['experience'];
            $ojt->save();

            $user = Auth::user();
            $user->experience = $user->experience ?? 0;
            $user->experience = $user->experience + $action['experience'];
            if($ojt->category == '勉強'){
                $user->study_experience = $user->study_experience ?? 0;
                $user->study_experience = $user->study_experience + $action['experience'];
            }else if($ojt->category == 'ボディメイク'){
                $user->bodymake_experience = $user->bodymake_experience ?? 0;
                $user->bodymake_experience = $user->bodymake_experience + $action['experience'];
            }else if($ojt->category == 'ビジネス'){
                $user->business_experience = $user->business_experience ?? 0;
                $user->business_experience = $user->business_experience + $action['experience'];
            }else if($ojt->category == 'お金'){
                $user->money_experience = $user->money_experience ?? 0;
                $user->money_experience = $user->money_experience + $action['experience'];
            }else if($ojt->category == '趣味'){
                $user->hobby_experience = $user->hobby_experience ?? 0;
                $user->hobby_experience = $user->hobby_experience + $action['experience'];
            }else if($ojt->category == '生活'){
                $user->life_experience = $user->life_experience ?? 0;
                $user->life_experience = $user->life_experience + $action['experience'];
            }else if($ojt->category == 'その他'){
                $user->other_experience = $user->other_experience ?? 0;
                $user->other_experience = $user->other_experience + $action['experience'];
            }
            $user->save();
        }

        return response($post, 201);
    }
}
