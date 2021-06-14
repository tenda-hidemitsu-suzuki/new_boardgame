<?php

use Illuminate\Support\Facades\Route;

//LoginControllerを使う
use App\Http\Controllers\LoginController;

//ItemControllerを使う
use App\Http\Controllers\ItemController;

//RegistControllerを使う
use App\Http\Controllers\RegistController;
//TagControllerを使う
use App\Http\Controllers\TagController;

//SalesHistoryControllerを使う
use App\Http\Controllers\SalesHistoryController;
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

Route::get('/', function () {
    return view('welcome');
});


//ヘッダー
//Route::get('/header', 'App\Http\Controllers\Header_Controller@user_header');
//Route::post('/header', 'App\Http\Controllers\Header_Controller@user_header');

//ログインフォーム
Route::get('/board_user/BoardUserLogin', [LoginController::class, 'login_form']);
//DBを使用した会員名とpasswordの照合
Route::post('/board_user/BoardUserLogin', [LoginController::class, 'login_check']);



use App\Http\Controllers\item_list_controller;
//ヘッダーから商品一覧へ遷移
Route::get('/board_user/item_list', 'App\Http\Controllers\item_list_controller@from_header');
Route::post('/board_user/item_list', 'App\Http\Controllers\item_list_controller@search');
Route::get('/board_user/item_list_all_tag', 'App\Http\Controllers\item_list_controller@all_tag');
Route::post('/board_user/banner', 'App\Http\Controllers\item_list_controller@banner');

use App\Http\Controllers\home_page_controller;
Route::get('/board_user/home_page', 'App\Http\Controllers\home_page_controller@from_header');


//ランキング
Route::get('/board_user/ranking', 'App\Http\Controllers\Ranking_Controller@ranking');


//商品個別ページ
Route::post('/board_user/item_individual', [ItemController::class, 'item_indicates']);


//カートページ
use App\Http\Controllers\CartController;
Route::get('/board_user/cart', [CartController::class, 'header']);
Route::post('/board_user/cart', [CartController::class, 'header']);
Route::get('/board_user/cart_header', [CartController::class, 'header']);
Route::post('/board_user/cart_header', [CartController::class, 'header']);
Route::get('/board_user/cart_item', [CartController::class, 'item']);
Route::post('/board_user/cart_item', [CartController::class, 'item']);


//お客様情報入力フォーム
use App\Http\Controllers\BuyController;
Route::get('/board_user/input_buy', [BuyController::class, 'index']);
Route::post('/board_user/input_buy', [BuyController::class, 'index']);

//バリデーションチェック&購入確認画面
Route::get('/board_user/confirm_buy', [BuyController::class, 'buy_check']);
Route::post('/board_user/confirm_buy', [BuyController::class, 'buy_check']);


//購入完了画面
Route::get('/board_user/complete_buy', [BuyController::class, 'buy_insert']);
Route::post('/board_user/complete_buy', [BuyController::class, 'buy_insert']);


//新規会員登録フォーム
Route::get('/board_user/new_member_input', [RegistController::class, 'index']);
//バリデーションチェック&会員登録確認画面
Route::post('/board_user/new_member_confirm', [RegistController::class, 'regist_check']);
//会員登録完了画面
Route::post('/board_user/new_member_complete', [RegistController::class, 'user_insert']);





//サイドバー
Route::get('/sidebar', 'App\Http\Controllers\Sidebar_Controller@sidebar');
Route::post('/sidebar', 'App\Http\Controllers\Sidebar_Controller@sidebar');



//管理者ログイン
Route::get('/board_manager/manager_login', [LoginController::class, 'manager_login']);
//DBを使用した管理者idとpasswordの照合
Route::post('/board_manager/manager_login', [LoginController::class, 'manager_check']);


//管理者パスワード変更
Route::get('/board_manager/change_password', [LoginController::class, 'change_password']);
//管理者パスワード変更できるかの判定
Route::post('/board_manager/change_password', [LoginController::class, 'pass_check']);



//簡単検索編集
Route::get('/board_manager/simple_search', [TagController::class, 'simple_search']);
Route::post('/board_manager/simple_search', [TagController::class, 'simple_search']);

//バナー編集
Route::get('/board_manager/banner', [TagController::class, 'banner']);
Route::post('/board_manager/banner', [TagController::class, 'banner']);


//購入履歴
Route::get('/board_manager/sales_history', [SalesHistoryController::class, 'sales_history']);



//管理者ホーム
Route::get('/board_manager/manager_home', [LoginController::class, 'manager_home']);

//商品情報編集
Route::get('board_manager/item_edit', 'App\Http\Controllers\item_edit_controller@header');
Route::post('/board_manager/item_info_insert', 'App\Http\Controllers\item_edit_controller@item_info_insert');
Route::post('/board_manager/item_info_delete', 'App\Http\Controllers\item_edit_controller@item_info_delete');
Route::post('/board_manager/item_info_edit_appoint', 'App\Http\Controllers\item_edit_controller@item_info_edit_appoint');
Route::post('/board_manager/item_info_edit', 'App\Http\Controllers\item_edit_controller@item_info_edit');
Route::post('/board_manager/item_tag_edit_appoint', 'App\Http\Controllers\item_edit_controller@item_tag_edit_appoint');
Route::post('/board_manager/item_tag_add', 'App\Http\Controllers\item_edit_controller@item_tag_add');
Route::post('/board_manager/item_tag_delete', 'App\Http\Controllers\item_edit_controller@item_tag_delete');
Route::post('/board_manager/tag_add', 'App\Http\Controllers\item_edit_controller@tag_add');
Route::post('/board_manager/tag_delete', 'App\Http\Controllers\item_edit_controller@tag_delete');

