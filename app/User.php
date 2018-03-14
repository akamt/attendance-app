<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 部下の一覧を取得
     * 
     * @param $roleId
     * @param $groupId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserList($roleId, $groupId)
    {
        // TODO この実装でいいのか確認
        if ($roleId === 1 || $roleId === 3) {
            $userList = DB::table('users')
                ->select('users.*')
                ->get();
        } elseif ($roleId === 2) {
            $userList = DB::table('users')
                ->select('users.*')
                ->where('group_id', '=', $groupId)
                ->get();
        }

        // 取得できない場合
        if ($userList->isEmpty()) {
            // TODO error messageを考える
            return response()->json(['message' => 'not data'], 201);
        }

        return $userList;
    }

    public function role()
    {
        return $this->hasMany('App\Role');
    }

    public function expenses()
    {
        return $this->hasMany('App\Expense');
    }
}
