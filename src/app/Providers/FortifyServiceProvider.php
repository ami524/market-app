<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::registerView(function () {
            return view('register');
        });

    // ログインビューの登録
    Fortify::loginView(function () {
        return view('login');
    });

    RateLimiter::for('login', function (Request $request) {
        $email = (string) $request->email;

        return Limit::perMinute(10)->by($email . $request->ip());
    });

    // ログイン画面に遷移
    Fortify::redirects('register', '/login');

    Fortify::authenticateUsing(function ($request) {
        $login = $request->input('email');
        $password = $request->input('password');

        // メールアドレスまたはユーザー名でユーザーを検索
        $user = \App\Models\User::where('email', $login)
            ->orWhere('name', $login)
            ->first();

        // パスワードの確認
        if ($user && \Hash::check($password, $user->password)) {
            return $user;
            }
        });
    }
}
