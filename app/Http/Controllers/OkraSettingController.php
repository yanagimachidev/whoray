<?php

namespace App\Http\Controllers;

use App\User;
use App\Objective;
use App\KeyResult;
use App\Action;
use App\Http\Requests\ObjectiveSetting;
use App\Http\Requests\KeyResultSetting;
use App\Http\Requests\ActionSetting;
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
     * 目標一覧
     */
    public function indexObjective()
    {
        $objectives = User::where('id', Auth::id())->with('objectives')->get();
        return $objectives;
    }

    /**
     * 目標設定
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
     * 目的一覧
     */
    public function indexKeyResult()
    {
        $keyResults = User::where('id', Auth::id())->with('keyResults')->get();
        return $keyResults;
    }

    /**
     * 目的設定
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
     * アクション一覧
     */
    public function indexAction()
    {
        $actions = User::where('id', Auth::id())->with('actions')->get();
        return $actions;
    }

    /**
     * 目的設定
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
}
