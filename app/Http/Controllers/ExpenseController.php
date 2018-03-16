<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Expense;

class ExpenseController extends Controller
{
    protected $user;

    /**
     * ExpenseController constructor.
     *
     */
    public function __construct()
    {
        $this->user = \JWTAuth::parseToken()->authenticate();
    }

    /**
     * userIdを比較
     * 権限に応じて返す
     *
     * @param integer $userId
     * @return boolean
     */
    private function isAdmin($userId)
    {
        // 自分自身のID
        $myUserId = $this->user->id;

        if ($userId != $myUserId) {
            if ($this->user->can('admin')) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * 期間の一覧を返す
     *
     * @param integer $userId
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\Collection
     */
    public function getPeriod($userId)
    {
        if ($this->isAdmin($userId)) {
            $expense = new Expense();
            return $expense->periodList($userId);
        } else {
            return response()->json(['message' => 'non admin'], 405);
        }
    }

    /**
     * 経費一覧を返す
     *
     * @param $userId
     * @param $period
     * @return \Illuminate\Support\Collection
     */
    public function show($userId, $period)
    {
        if ($this->isAdmin($userId)) {
            $expense = new Expense();
            return $expense->getList($userId, $period);
        } else {
            return response()->json(['message' => 'non admin'], 405);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param integer $userId
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function store($userId, Request $request)
    {
        if ($this->isAdmin($userId)) {
            $expenses = $request->forms;
            foreach ($expenses as $item) {
                $item['user_id'] = $userId;
                $item['use_day'] = Carbon::createFromFormat('Y-m-d', $item['date'])->format('Y-m-d');
                $item['month'] = Carbon::createFromFormat('Y-m-d', $item['date'])->format('Y-m');
                $expense = new Expense($item);
                $expense->save();
            }
        } else {
            return response()->json(['message' => 'non admin'], 405);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param integer $userId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId)
    {
        if ($this->isAdmin($userId)) {
            $updateData = $request->updateData;
            foreach ($updateData as $id => $value) {
                $expense = Expense::find($id);
                $expense->fill($value)->save();
            }
        } else {
            return response()->json(['message' => 'non admin'], 405);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param integer $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $userId)
    {
        if ($this->isAdmin($userId)) {
            $deleteData = $request->deleteData;
            foreach ($deleteData as $value) {
                $expense = Expense::find($value['id']);
                $expense->delete();
            }
        } else {
            return response()->json(['message' => 'non admin'], 405);
        }
    }
}
