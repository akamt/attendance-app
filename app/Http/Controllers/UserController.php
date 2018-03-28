<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;

class UserController extends Controller
{
    protected $userInfo;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userInfo = \JWTAuth::parseToken()->authenticate();
    }

    /**
     * 部下の一覧を返す
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = new User();
        return $user->getUserList($this->userInfo->role_id, $this->userInfo->group_id);
    }

    /**
     * ユーザ情報を返す
     *
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    public function getUserInfo($id)
    {
        return $userInfo = User::find($id);
    }
}
