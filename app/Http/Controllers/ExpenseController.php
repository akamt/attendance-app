<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Expense;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function getExpenseList(Request $request)
    {
        $user = \JWTAuth::parseToken()->authenticate();
        $expense = new Expense();

        return $expense->expenseList($user->id, $request->period);
    }

    /**
     * 期間の一覧を返す
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPeriodList()
    {
        $user = \JWTAuth::parseToken()->authenticate();
        $expense = new Expense();

        return $expense->expensePeriodList($user->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $user = \JWTAuth::parseToken()->authenticate();
        $array = $request->forms;

        foreach ($array as $item) {
            $item['user_id'] = $user->id;
            $item['use_day'] = Carbon::createFromFormat('Y-m-d', $item['date'])->format('Y-m-d');
            $item['month'] = Carbon::createFromFormat('Y-m-d', $item['date'])->format('Y-m');
            $expense = new Expense($item);
            $expense->save();
        }
        return $user->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::find($id);
        $expense->fill($request->all())->save();

        return response()->json('updated!', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        $expense->delete();

        return response()->json('deleted!', 200);
    }
}
