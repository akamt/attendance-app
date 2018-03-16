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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $roles = \JWTAuth::parseToken()->authenticate();
        $user = new User();
        return $user->getUserList($roles->role_id, $roles->group_id);
    }
}
