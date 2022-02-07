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
            foreach($actionPost['actions'] as $action){
                $action->experience = null;
                $action->count = null;
            }
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
        $post->action_text = nl2br($request->get('actionText'));
        $post->action_date = $request->get('actionDate');
        Auth::user()->posts()->save($post);

        $actions = $request->get('actions');
        $actionSummary = array();
        foreach($actions as $action){
            if($action['experience'] != 0 || $action['count'] != 0 || $action['experience'] != null || $action['count'] != null){
                if($action['experience'] == null){
                    $action['experience'] = 0;
                }
                if($action['count'] == null){
                    $action['count'] = 0;
                }
                
                $actionSummary[] = $action;

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
                $act->count = $act->count + $action['count'];
                $act->save();

                $kr = KeyResult::find($action['key_result_id']);
                $kr->experience = $kr->experience + $action['experience'];
                $kr->save();

                $ojt = Objective::find($action['objective_id']);
                $ojt->experience = $ojt->experience + $action['experience'];
                $ojt->save();

                $user = Auth::user();
                $user->experience = $user->experience + $action['experience'];
                if($ojt->category == '勉強'){
                    $user->study_experience = $user->study_experience + $action['experience'];
                }else if($ojt->category == 'ボディメイク'){
                    $user->bodymake_experience = $user->bodymake_experience + $action['experience'];
                }else if($ojt->category == 'ビジネス'){
                    $user->business_experience = $user->business_experience + $action['experience'];
                }else if($ojt->category == 'お金'){
                    $user->money_experience = $user->money_experience + $action['experience'];
                }else if($ojt->category == '趣味'){
                    $user->hobby_experience = $user->hobby_experience + $action['experience'];
                }else if($ojt->category == '生活'){
                    $user->life_experience = $user->life_experience + $action['experience'];
                }else if($ojt->category == 'その他'){
                    $user->other_experience = $user->other_experience + $action['experience'];
                }
                $user->save();
            }

            $post->action_summary = serialize($actionSummary);
            $post->save();
        }

        return response($post, 201);
    }
}
