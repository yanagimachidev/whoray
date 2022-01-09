<?php

namespace App\Http\Controllers;

use App\User;
use App\Objective;
use App\KeyResult;
use App\Action;
use App\Http\Requests\ObjectiveSetting;
use App\Http\Requests\ObjectiveStatusUpdate;
use App\Http\Requests\KeyResultSetting;
use App\Http\Requests\KeyResultStatusUpdate;
use App\Http\Requests\ActionSetting;
use App\Http\Requests\ActionStatusUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OkraSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 目標・目的・アクション一覧
     */
    public function indexOkra()
    {
        $objectives = User::where('id', Auth::id())->with(['objectives.keyResults.actions'])->get();
        return $objectives;
    }

    /**
     * 目的一覧
     */
    public function indexObjective()
    {
        $objectives = User::where('id', Auth::id())->with('objectives')->get();
        return $objectives;
    }

    /**
     * 目的設定
     * @param ObjectiveSetting $request
     * @return \Illuminate\Http\Response
     */
    public function createObjective(ObjectiveSetting $request)
    {
        $objective = new Objective();
        $objective->name = $request->get('name');
        $objective->category = $request->get('category');
        $objective->status = '積み上げ中';
        $objective->experience = 0;
        Auth::user()->Objectives()->save($objective);
        return response($objective, 201);
    }

    /**
     * 目的のステータス設定
     * @param ObjectiveStatusUpdate $request
     * @return \Illuminate\Http\Response
     */
    public function statusUpdateObjective(ObjectiveStatusUpdate $request)
    {
        $objective = Objective::find($request->get('objectiveId'));
        $objective->status = $request->get('status');
        $objective->save();

        $keyResults = KeyResult::where([['status', '積み上げ中'], ['objective_id', $request->get('objectiveId')]])->get();
        foreach ($keyResults as $keyResult){
            $keyResult->status = '目的' . $request->get('status');
            $keyResult->save();
        }

        $actions = Action::where([['status', '積み上げ中'], ['objective_id', $request->get('objectiveId')]])->get();
        foreach ($actions as $action){
            $action->status = '目的' . $request->get('status');
            $action->save();
        }

        return response($objective, 201);
    }

    /**
     * 目標一覧
     */
    public function indexKeyResult()
    {
        $keyResults = User::where('id', Auth::id())->with('keyResults')->get();
        return $keyResults;
    }

    /**
     * 目標設定
     * @param KeyResultSetting $request
     * @return \Illuminate\Http\Response
     */
    public function createKeyResult(KeyResultSetting $request)
    {
        $keyResult = new KeyResult();
        $keyResult->objective_id = $request->get('objectiveId');
        $keyResult->name = $request->get('name');
        $keyResult->status = '積み上げ中';
        $keyResult->experience = 0;
        Auth::user()->keyResults()->save($keyResult);
        return response($keyResult, 201);
    }

    /**
     * 目標のステータス設定
     * @param KeyResultStatusUpdate $request
     * @return \Illuminate\Http\Response
     */
    public function statusUpdateKeyResult(KeyResultStatusUpdate $request)
    {
        $keyResult = KeyResult::find($request->get('keyResultId'));
        $keyResult->status = $request->get('status');
        $keyResult->save();

        $actions = Action::where([['status', '積み上げ中'], ['key_result_id', $request->get('keyResultId')]])->get();
        foreach ($actions as $action){
            $action->status = '目的' . $request->get('status');
            $action->save();
        }

        return response($keyResult, 201);
    }

    /**
     * アクション一覧
     */
    public function indexAction()
    {
        $actions = User::where('id', Auth::id())->with('actions')->get();
        return $actions;
    }

    /**
     * アクション設定
     * @param ActionSetting $request
     * @return \Illuminate\Http\Response
     */
    public function createAction(ActionSetting $request)
    {
        $action = new Action();
        $action->objective_id = $request->get('objectiveId');
        $action->key_result_id = $request->get('keyResultId');
        $action->name = $request->get('name');
        $action->status = '積み上げ中';
        $action->unit = $request->get('unit');
        $action->experience = 0;
        $action->count = 0;
        Auth::user()->actions()->save($action);
        return response($action, 201);
    }

    /**
     * アクションのステータス設定
     * @param ActionStatusUpdate $request
     * @return \Illuminate\Http\Response
     */
    public function statusUpdateAction(ActionStatusUpdate $request)
    {
        $Action = Action::find($request->get('actionId'));
        $Action->status = $request->get('status');
        $Action->save();

        return response($Action, 201);
    }
}
