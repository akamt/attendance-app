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
     * @param $userId
     * @return \Illuminate\Support\Collection
     */
    public function expenseList($userId)
    {
        $list = DB::table('expenses')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select('expenses.*', 'categories.name as category_name')
            ->where('user_id', '=', $userId)
            ->get();

        return $list;
    }
}
