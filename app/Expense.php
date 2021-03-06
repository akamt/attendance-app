<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Expense extends Model
{
    protected $fillable = ['name', 'value', 'payment', 'use_day', 'month', 'user_id', 'category_id'];

    /**
     * 経費の一覧を返す
     *
     * @param integer $userId
     * @param string $period
     * @return \Illuminate\Support\Collection
     */
    public function getList($userId, $period)
    {
        $expenseList = DB::table('expenses')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select('expenses.*', 'categories.name as category_name')
            ->where([
                ['user_id', '=', $userId],
                ['month', '=', $period],
            ])
            ->orderBy('use_day', 'ASC')
            ->get();

        // 取得できない場合
        if ($expenseList->isEmpty()) {
            // TODO error messageを考える
            return response()->json(['message' => 'not data'], 201);
        }

        return $expenseList;
    }

    /**
     * 期間の一覧を返す
     *
     * @param integer $userId
     * @return \Illuminate\Support\Collection
     */
    public function periodList($userId)
    {
        $periodList = DB::table('expenses')
            ->distinct()
            ->select('expenses.month')
            ->where('user_id', '=', $userId)
            ->orderBy('month', 'asc')
            ->get();

        // 取得できない場合
        if ($periodList->isEmpty()) {
            // TODO error messageを考える
            return response()->json(['message' => 'not data'], 201);
        }

        return $periodList;
    }
}
