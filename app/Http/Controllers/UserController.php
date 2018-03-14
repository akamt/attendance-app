<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;

class UserController extends Controller
{
    /**
     * 部下の一覧を返す
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = \JWTAuth::parseToken()->authenticate();

        $user = new User();

        return $user->getUserList($roles->role_id, $roles->group_id);
    }

    /**
     * 登録されている経費の期間を取得
     *
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    public function getPeriodList($id)
    {
        $user = new User();
        return $user->getPeriodList($id);
    }

    /**
     * 経費一覧を返す
     *
     * @param $userId
     * @param $period
     * @return \Illuminate\Support\Collection
     */
    public function getExpenseList($userId, $period)
    {
        $user = new User();
        return $user->getExpenseList($userId, $period);
    }
}
