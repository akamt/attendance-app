<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 'admin'ゲートを定義
        // role_idDが 1 / 2 / 3 のユーザーを管理者とする
        Gate::define('admin', function ($user) {
            return ($user->role_id === 1 || $user->role_id === 2||$user->role_id === 3);
        });
    }
}
