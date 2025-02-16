<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//トップページ
Route::get('/', [ItemController::class, 'index'])->name('index');


// 会員登録フォームを表示
Route::get('/register', [ItemController::class, 'showRegistrationForm'])->name('register');
// 会員登録処理
Route::post('/register', [ItemController::class, 'register']);
// 認証関連のルート
Route::get('/login', [ItemController::class, 'showLoginForm'])->name('login');
Route::post('/login', [ItemController::class, 'login'])->name('login');
Route::post('/logout', [ItemController::class, 'destroy'])->name('logout');


// マイページ
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [ItemController::class, 'index'])->name('mypage')->middleware('auth');
    Route::get('/mypage/profile', [ItemController::class, 'edit'])->name('profile.edit')->middleware('auth');
    Route::post('/mypage/profile/update', [ItemController::class, 'update'])->name('profile.update')->middleware('auth');

    // 出品画面
    Route::get('/sell', [ItemController::class, 'create'])->name('sell');
    Route::post('/sell', [ItemController::class, 'store'])->name('sell');

    // 購入画面と住所変更
    Route::get('/purchase/{item_id}', [ItemController::class, 'showPurchase'])->name('purchase.page');
    Route::get('/purchase/address/{item_id}', [ItemController::class, 'changeAddress'])->name('purchase.address');
    Route::post('/purchase/{item_id}', [ItemController::class, 'process'])->name('purchase.process');

    // いいね機能
    Route::post('/like/{productId}', [ItemController::class, 'toggleLike'])->name('like.toggle');

    // コメント投稿
    Route::post('/comment/{id}', [ItemController::class, 'addComment'])->name('comment')->middleware('auth');

    // 検索機能
    Route::get('/search', [ItemController::class, 'search'])->name('search');
});


// プロフィール設定画面のルート
Route::get('mypage/profile', [ItemController::class, 'edit'])->name('profile.edit');
Route::post('/mypage/profile/update', [ItemController::class, 'update'])->name('profile.update');

Route::get('/home', function () {
    return view('mypage-edit');
})->name('home');


// 初回ログイン時のみプロフィール設定画面に遷移
Route::get('/mypage/edit', function () {
        return view('mypage-edit');
    })->name('profile.edit')->middleware('auth');


//購入済みの商品をチェック
Route::get('/product/{id}', [ItemController::class, 'show'])->name('product.show');

//詳細画面
Route::get('/item/{id}', [ItemController::class, 'show'])->name('item.show');
Route::post('/like/{id}', [ItemController::class, 'toggleLike'])->middleware('auth');


Route::get('/mypage?tab=sell', [ItemController::class, 'mypage']);
Route::get('/mypage?tab=buy', [ItemController::class, 'mypage']);


Route::get('/purchase/address/{item_id}', [ItemController::class, 'editAddress'])->name('purchase.address');
Route::post('/purchase/address/{item_id}', [ItemController::class, 'updateAddress'])->name('purchase.address.update');
