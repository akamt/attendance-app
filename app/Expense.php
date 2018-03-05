<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Expense extends Model
{
    protected $fillable = ['name', 'value', 'payment', 'month', 'user_id', 'category_id'];

    /**
     * 経費の一覧を返す
     *
     * @param integer $userId
     * @param string $period
     * @return \Illuminate\Support\Collection
     */
    public function expenseList($userId, $period)
    {
        $expenseList = DB::table('expenses')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select('expenses.*', 'categories.name as category_name')
            ->where([
                ['user_id', '=', $userId],
                ['month', '=', $period],
            ])
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
    public function expensePeriodList($userId)
    {
        $periodList = DB::table('expenses')
            ->distinct()
            ->select('expenses.month')
            ->where('user_id', '=', $userId)
            ->orderBy('month', 'asc')
            ->get();

        return $periodList;
    }
}
